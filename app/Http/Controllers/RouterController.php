<?php

namespace App\Http\Controllers;

use App\Models\InternetSim;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Routers as first-class records, separate from devices, and the SIM line
 * fitted in each one.
 *
 * The add/edit form covers both: one screen per line on the site internet
 * sheet, rather than making somebody record a router here and its SIM
 * somewhere else. A router with no SIM yet is fine, and extra SIMs for the
 * same router can still be added on the Internet SIMs page.
 */
class RouterController extends Controller
{
    public function index(Request $request)
    {
        $query = Router::with('simCards')->withCount('simCards');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('isp_provider', 'like', "%{$search}%")
                    ->orWhere('account_site', 'like', "%{$search}%")
                    ->orWhereHas('simCards', fn ($sq) => $sq->where('sim_number', 'like', "%{$search}%")
                        ->orWhere('account_name', 'like', "%{$search}%"));
            });
        }

        // "deleted" is not a status value - it selects a different set of rows.
        $status = $request->input('status', 'all');
        if ($status === 'deleted') {
            $query->onlyTrashed();
        } elseif ($status !== 'all') {
            $query->where('status', $status);
        }

        $routers = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('routers.index', compact('routers'));
    }

    public function create()
    {
        return view('routers.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRouter($request);

        $router = Router::create($this->routerAttributes($validated));

        if ($request->hasFile('main_image')) {
            $router->update(['main_image' => $this->storeUpload($request->file('main_image'))]);
        }

        $this->syncSim($router, $validated);

        return redirect()->route('routers.show', $router->id)->with('success', 'Router saved.');
    }

    public function show(Router $router)
    {
        $router->load('simCards');

        return view('routers.show', compact('router'));
    }

    public function edit(Router $router)
    {
        return view('routers.edit', [
            'router' => $router,
            'sim' => $router->primarySim(),
        ]);
    }

    public function update(Request $request, Router $router)
    {
        $validated = $this->validateRouter($request);

        $router->update($this->routerAttributes($validated));

        if ($request->hasFile('main_image')) {
            $old = $router->main_image;
            $router->update(['main_image' => $this->storeUpload($request->file('main_image'))]);
            $this->deleteUpload($old);
        }

        $this->syncSim($router, $validated);

        return redirect()->route('routers.show', $router->id)->with('success', 'Router saved.');
    }

    /**
     * Soft delete: the record and its SIM pairing stay intact, so a router
     * removed by mistake can be restored.
     */
    public function destroy(Router $router)
    {
        $router->delete();

        return redirect()->route('routers.index')
            ->with('success', 'Router deleted. You can restore it from the Deleted filter.');
    }

    public function restore(int $routerId)
    {
        $router = Router::onlyTrashed()->findOrFail($routerId);
        $router->restore();

        return redirect()->route('routers.show', $router->id)->with('success', 'Router restored.');
    }

    /** Erases a deleted router for good, with its image. Not recoverable. */
    public function forceDestroy(int $routerId)
    {
        $router = Router::onlyTrashed()->findOrFail($routerId);

        // Any SIM still fitted is unpaired rather than deleted - the line
        // exists with the provider whether or not we still have the router.
        $router->simCards()->update(['router_id' => null]);
        $this->deleteUpload($router->main_image);
        $router->forceDelete();

        return redirect()->route('routers.index', ['status' => 'deleted'])
            ->with('success', 'Router permanently deleted.');
    }

    private function validateRouter(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'isp_provider' => 'nullable|string|max:255',
            'account_site' => 'nullable|string|max:255',
            'status' => 'required|in:in-stock,active,faulty,retired',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string|max:1000',

            // The SIM fitted in it. All optional: a router can be recorded
            // before its line is arranged.
            'sim_number' => 'nullable|string|max:255',
            'sim_serial' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'contract_no' => 'nullable|string|max:255',
            'line_active' => 'nullable|boolean',
            'remark' => 'nullable|string|max:255',
        ]);
    }

    private function routerAttributes(array $v): array
    {
        return [
            'name' => $v['name'],
            'brand' => $v['brand'] ?? null,
            'model' => $v['model'] ?? null,
            'serial_number' => $v['serial_number'] ?? null,
            'isp_provider' => $v['isp_provider'] ?? null,
            'account_site' => $v['account_site'] ?? null,
            'status' => $v['status'],
            'notes' => $v['notes'] ?? null,
        ];
    }

    /**
     * Create or update the router's SIM from the same form.
     *
     * A blank SIM number means "no SIM entered here" and leaves any existing
     * line alone rather than destroying it - removing a line is done from the
     * Internet SIMs page, where it is an explicit act.
     *
     * The ISP and site are shared: one line, one provider, one place.
     */
    private function syncSim(Router $router, array $v): void
    {
        if (blank($v['sim_number'] ?? null)) {
            return;
        }

        $attributes = [
            'sim_number' => $v['sim_number'],
            'sim_provider' => $v['isp_provider'] ?? '-',
            'sim_serial' => $v['sim_serial'] ?? null,
            'account_name' => $v['account_name'] ?? null,
            'contract_no' => $v['contract_no'] ?? null,
            // An unchecked checkbox is simply absent from the request.
            'line_active' => (bool) ($v['line_active'] ?? false),
            'account_site' => $v['account_site'] ?? null,
            'remark' => $v['remark'] ?? null,
            'router_id' => $router->id,
        ];

        $sim = $router->primarySim();

        $sim ? $sim->update($attributes) : InternetSim::create($attributes);
    }

    private function storeUpload($file): string
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('X-Files/Dash/imgs/devices'), $fileName);

        return $fileName;
    }

    /** Never removes the shared placeholder image. */
    private function deleteUpload(?string $fileName): void
    {
        if (!$fileName || $fileName === 'default_device.png') {
            return;
        }

        $path = public_path('X-Files/Dash/imgs/devices/' . $fileName);
        if (is_file($path)) {
            unlink($path);
        }
    }
}
