<?php

namespace App\Http\Controllers;

use App\Models\ClientEmployee;
use App\Models\Consultant;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Router;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Routers as first-class records, separate from devices. Existing
 * device_type='Router' devices are left alone as history; anything recorded
 * here is a router in its own right, and can carry the SIM cards fitted in it.
 */
class RouterController extends Controller
{
    public function index(Request $request)
    {
        $query = Router::with(['supplier', 'employee', 'department', 'project', 'clientEmployee', 'consultant'])
            ->withCount('simCards');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', fn ($sq) => $sq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('employee', fn ($sq) => $sq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('project', fn ($sq) => $sq->where('project_name', 'like', "%{$search}%"));
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
        return view('routers.create', $this->holderOptions());
    }

    public function store(Request $request)
    {
        $validated = $this->validateRouter($request);

        $router = Router::create(array_merge(
            $this->routerAttributes($validated),
            $this->resolveHolder($validated)
        ));

        if ($request->hasFile('main_image')) {
            $router->update(['main_image' => $this->storeUpload($request->file('main_image'))]);
        }

        return redirect()->route('routers.show', $router->id)->with('success', 'Router added.');
    }

    public function show(Router $router)
    {
        $router->load(['supplier', 'employee', 'department', 'project', 'clientEmployee', 'consultant', 'simCards']);

        return view('routers.show', compact('router'));
    }

    public function edit(Router $router)
    {
        return view('routers.edit', array_merge(['router' => $router], $this->holderOptions()));
    }

    public function update(Request $request, Router $router)
    {
        $validated = $this->validateRouter($request);

        $router->update(array_merge(
            $this->routerAttributes($validated),
            $this->resolveHolder($validated)
        ));

        if ($request->hasFile('main_image')) {
            $old = $router->main_image;
            $router->update(['main_image' => $this->storeUpload($request->file('main_image'))]);
            $this->deleteUpload($old);
        }

        return redirect()->route('routers.show', $router->id)->with('success', 'Router updated.');
    }

    /**
     * Soft delete: the record and any SIM pairing stay intact, so a router
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

        // Any SIM still pointing at it is unpaired rather than deleted.
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
            'supplier_id' => 'nullable|exists:suppliers,id',
            'status' => 'required|in:in-stock,active,faulty,retired',
            'holder_type' => 'nullable|in:employee,department,project,client,consultant',
            'holder_id' => 'nullable|integer|required_with:holder_type',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);
    }

    private function routerAttributes(array $v): array
    {
        return [
            'name' => $v['name'],
            'brand' => $v['brand'] ?? null,
            'model' => $v['model'] ?? null,
            'serial_number' => $v['serial_number'] ?? null,
            'supplier_id' => $v['supplier_id'] ?? null,
            'status' => $v['status'],
            'notes' => $v['notes'] ?? null,
        ];
    }

    /**
     * Only one holder column may be set, so every one is cleared first and the
     * chosen kind written back.
     */
    private function resolveHolder(array $v): array
    {
        $holders = (new Router)->clearHolders();

        if (empty($v['holder_type']) || empty($v['holder_id'])) {
            return $holders;
        }

        $column = match ($v['holder_type']) {
            'employee' => 'employee_id',
            'department' => 'department_id',
            'project' => 'project_id',
            'client' => 'client_employee_id',
            'consultant' => 'consultant_id',
        };

        $holders[$column] = $v['holder_id'];

        return $holders;
    }

    private function holderOptions(): array
    {
        return [
            'suppliers' => Supplier::orderBy('name')->get(),
            'employees' => Employee::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
            'projects' => Project::orderBy('project_name')->get(),
            'clientEmployees' => ClientEmployee::orderBy('name')->get(),
            'consultants' => Consultant::orderBy('name')->get(),
        ];
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
