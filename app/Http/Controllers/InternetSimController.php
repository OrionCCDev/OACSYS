<?php

namespace App\Http\Controllers;

use App\Models\InternetSim;
use App\Models\Router;
use Illuminate\Http\Request;

/**
 * Site internet SIM lines, entered here rather than in the SIM Cards module.
 * That module is the IT asset register; these are provider accounts standing
 * behind site routers and cameras, and the monthly report is built from them.
 */
class InternetSimController extends Controller
{
    public function index(Request $request)
    {
        $query = InternetSim::with('router');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('sim_number', 'like', "%{$search}%")
                    ->orWhere('sim_serial', 'like', "%{$search}%")
                    ->orWhere('account_name', 'like', "%{$search}%")
                    ->orWhere('contract_no', 'like', "%{$search}%")
                    ->orWhere('remark', 'like', "%{$search}%")
                    ->orWhere('account_site', 'like', "%{$search}%")
                    ->orWhereHas('router', fn ($rq) => $rq->where('serial_number', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('provider')) {
            $query->where('sim_provider', $request->input('provider'));
        }

        // "deleted" selects a different set of rows, not a line state.
        $line = $request->input('line', 'all');
        if ($line === 'deleted') {
            $query->onlyTrashed();
        } elseif ($line === 'active') {
            $query->where('line_active', true);
        } elseif ($line === 'inactive') {
            $query->where('line_active', false);
        }

        $sims = $query->orderBy('sim_provider')->orderBy('account_name')->orderBy('sim_number')
            ->paginate(20)->withQueryString();

        $providers = InternetSim::select('sim_provider')->distinct()->orderBy('sim_provider')->pluck('sim_provider');

        return view('internet-sims.index', compact('sims', 'providers'));
    }

    public function create()
    {
        return view('internet-sims.create', $this->formOptions());
    }

    public function store(Request $request)
    {
        $validated = $this->validateSim($request);

        InternetSim::create($this->simAttributes($validated));

        return redirect()->route('internet-sims.index')->with('success', 'Internet SIM added.');
    }

    public function edit(InternetSim $internetSim)
    {
        return view('internet-sims.edit', array_merge(['sim' => $internetSim], $this->formOptions()));
    }

    public function update(Request $request, InternetSim $internetSim)
    {
        $validated = $this->validateSim($request, $internetSim->id);

        $internetSim->update($this->simAttributes($validated));

        return redirect()->route('internet-sims.index')->with('success', 'Internet SIM updated.');
    }

    /** Soft delete, so a line removed by mistake can be brought back. */
    public function destroy(InternetSim $internetSim)
    {
        $internetSim->delete();

        return redirect()->route('internet-sims.index')
            ->with('success', 'Internet SIM deleted. You can restore it from the Deleted filter.');
    }

    public function restore(int $simId)
    {
        InternetSim::onlyTrashed()->findOrFail($simId)->restore();

        return redirect()->route('internet-sims.index')->with('success', 'Internet SIM restored.');
    }

    public function forceDestroy(int $simId)
    {
        InternetSim::onlyTrashed()->findOrFail($simId)->forceDelete();

        return redirect()->route('internet-sims.index', ['line' => 'deleted'])
            ->with('success', 'Internet SIM permanently deleted.');
    }

    private function validateSim(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'sim_number' => 'required|string|max:255',
            'sim_provider' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'sim_serial' => 'nullable|string|max:255',
            'contract_no' => 'nullable|string|max:255',
            'line_active' => 'nullable|boolean',
            'router_id' => 'nullable|exists:routers,id',
            'account_site' => 'nullable|string|max:255',
            'remark' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);
    }

    private function simAttributes(array $v): array
    {
        return [
            'sim_number' => $v['sim_number'],
            'sim_provider' => $v['sim_provider'],
            'account_name' => $v['account_name'] ?? null,
            'sim_serial' => $v['sim_serial'] ?? null,
            'contract_no' => $v['contract_no'] ?? null,
            // An unchecked checkbox is simply absent from the request.
            'line_active' => (bool) ($v['line_active'] ?? false),
            'router_id' => $v['router_id'] ?? null,
            'account_site' => $v['account_site'] ?? null,
            'remark' => $v['remark'] ?? null,
            'notes' => $v['notes'] ?? null,
        ];
    }

    private function formOptions(): array
    {
        return [
            'routers' => Router::orderBy('name')->get(),
        ];
    }
}
