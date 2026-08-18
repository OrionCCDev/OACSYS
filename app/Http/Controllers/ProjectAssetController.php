<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Project;
use App\Models\Receive;
use App\Models\SimCard;
use App\Models\Clearance;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DeviceAndSimReceive;
use App\Models\ProjectAssetTransfer;
use App\Models\DeviceAndSimClearance;

class ProjectAssetController extends Controller
{
    /**
     * Display all projects with their assets
     */
    public function index()
    {
        $projects = Project::with(['devices', 'simCards', 'manager', 'client'])
            ->where('status', 'in-progress')
            ->paginate(10);

        return view('project-assets.index', compact('projects'));
    }

    /**
     * Show a specific project's assets
     */
    public function show($id)
    {
        $project = Project::with(['devices', 'simCards', 'manager', 'client', 'receives', 'clearances', 'transfersFrom', 'transfersTo'])
            ->findOrFail($id);

        $assetsCount = $project->getAssetsCount();

        return view('project-assets.show', compact('project', 'assetsCount'));
    }

    /**
     * Show form to receive assets to a project
     */
    public function createReceive($projectId)
    {
        $project = Project::findOrFail($projectId);

        // Get available devices and sim cards (not assigned to anyone)
        $availableDevices = Device::where('status', 'available')
            ->whereNull('employee_id')
            ->whereNull('consultant_id')
            ->whereNull('client_id')
            ->whereNull('project_id')
            ->whereNull('department_id')
            ->get();

        $availableSimCards = SimCard::where('status', 'available')
            ->whereNull('employee_id')
            ->whereNull('consultant_id')
            ->whereNull('client_employee_id')
            ->whereNull('project_id')
            ->whereNull('department_id')
            ->get();

        return view('project-assets.receive.create', compact('project', 'availableDevices', 'availableSimCards'));
    }

    /**
     * Store receive for project assets
     */
    public function storeReceive(Request $request, $projectId)
    {
        $request->validate([
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devices,id',
            'sim_cards' => 'nullable|array',
            'sim_cards.*' => 'exists:sim_cards,id',
            'device_notes' => 'nullable|array',
            'sim_notes' => 'nullable|array',
        ]);

        if (empty($request->devices) && empty($request->sim_cards)) {
            return redirect()->back()->with('error', 'Please select at least one device or SIM card to receive.');
        }

        return DB::transaction(function () use ($request, $projectId) {
            $project = Project::findOrFail($projectId);
            $skipped = [];

            // Create receive record
            $receive = Receive::create([
                'code' => 'RCV-' . strtoupper(Str::random(10)),
                'project_id' => $projectId,
                'status' => 'pending',
            ]);

            // Add devices to receive
            if (!empty($request->devices)) {
                foreach ($request->devices as $index => $deviceId) {
                    $device = Device::findOrFail($deviceId);
                    if (!$this->deviceIsAvailable($device)) {
                        $skipped[] = $device->device_code . ' (no longer available)';
                        continue;
                    }
                    $device->update([
                        'status' => 'pending-receiving',
                        'project_id' => $projectId,
                    ]);

                    DeviceAndSimReceive::create([
                        'receive_id' => $receive->id,
                        'device_id' => $deviceId,
                        'notes' => $request->device_notes[$index] ?? null,
                    ]);
                }
            }

            // Add SIM cards to receive
            if (!empty($request->sim_cards)) {
                foreach ($request->sim_cards as $index => $simId) {
                    $simCard = SimCard::findOrFail($simId);
                    if (!$this->simCardIsAvailable($simCard)) {
                        $skipped[] = $simCard->sim_number . ' (no longer available)';
                        continue;
                    }
                    $simCard->update([
                        'status' => 'pending-receive',
                        'project_id' => $projectId,
                    ]);

                    DeviceAndSimReceive::create([
                        'receive_id' => $receive->id,
                        'sim_card_id' => $simId,
                        'notes' => $request->sim_notes[$index] ?? null,
                    ]);
                }
            }

            $message = 'Assets added to receive. Please upload signature to complete.';
            if ($skipped) {
                $message .= ' Skipped (already assigned elsewhere): ' . implode(', ', $skipped) . '.';
            }

            return redirect()->route('project-assets.receive.finish', $receive->id)
                ->with('success', $message);
        });
    }

    /**
     * Show page to finish receive (upload signature)
     */
    public function finishReceive($receiveId)
    {
        $receive = Receive::with(['project'])->findOrFail($receiveId);

        // Get devices and sim cards for this receive with notes
        $deviceRecords = DeviceAndSimReceive::where('receive_id', $receiveId)
            ->whereNotNull('device_id')
            ->with('device')
            ->get();

        $simRecords = DeviceAndSimReceive::where('receive_id', $receiveId)
            ->whereNotNull('sim_card_id')
            ->with('simCard')
            ->get();

        return view('project-assets.receive.finish', compact('receive', 'deviceRecords', 'simRecords'));
    }

    /**
     * Complete the receive process
     */
    public function completeReceive(Request $request, $receiveId)
    {
        $request->validate([
            'receiving_signature' => 'required|mimes:jpeg,png,jpg,svg,pdf|max:2048',
        ]);

        return DB::transaction(function () use ($request, $receiveId) {
            $receive = Receive::findOrFail($receiveId);

            // Upload signature
            if ($request->hasFile('receiving_signature')) {
                $image = $request->file('receiving_signature');
                $imageName = \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('X-Files/Dash/imgs/receives'), $imageName);

                $receive->receive_image = $imageName;
                $receive->status = 'received';
                $receive->save();
            }

            // Update all devices and sim cards status
            $records = DeviceAndSimReceive::where('receive_id', $receiveId)->get();

            foreach ($records as $record) {
                if ($record->device_id) {
                    Device::where('id', $record->device_id)->update([
                        'status' => 'In-Project-Site',
                    ]);
                }

                if ($record->sim_card_id) {
                    SimCard::where('id', $record->sim_card_id)->update([
                        'status' => 'taken',
                    ]);
                }
            }

            return redirect()->route('project-assets.show', $receive->project_id)
                ->with('success', 'Assets received successfully!');
        });
    }

    /**
     * Show form to create clearance for project assets
     */
    public function createClearance($projectId)
    {
        $project = Project::findOrFail($projectId);

        // Get devices and sim cards assigned to this project
        $projectDevices = Device::where('project_id', $projectId)
            ->whereIn('status', ['In-Project-Site', 'taken'])
            ->get();

        $projectSimCards = SimCard::where('project_id', $projectId)
            ->where('status', 'taken')
            ->get();

        return view('project-assets.clearance.create', compact('project', 'projectDevices', 'projectSimCards'));
    }

    /**
     * Store clearance for project assets
     */
    public function storeClearance(Request $request, $projectId)
    {
        $request->validate([
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devices,id',
            'sim_cards' => 'nullable|array',
            'sim_cards.*' => 'exists:sim_cards,id',
            'device_notes' => 'nullable|array',
            'sim_notes' => 'nullable|array',
        ]);

        if (empty($request->devices) && empty($request->sim_cards)) {
            return redirect()->back()->with('error', 'Please select at least one device or SIM card to clear.');
        }

        return DB::transaction(function () use ($request, $projectId) {
            $project = Project::findOrFail($projectId);
            $skipped = [];

            // Create clearance record (clear_code is generated by the model's creating() hook)
            $clearance = Clearance::create([
                'status' => 'pending',
                'project_id' => $projectId,
            ]);

            // Add devices to clearance - only ones actually on this project right now
            if (!empty($request->devices)) {
                foreach ($request->devices as $index => $deviceId) {
                    $device = Device::findOrFail($deviceId);
                    if ((int) $device->project_id !== (int) $projectId || !in_array($device->status, ['In-Project-Site', 'taken'])) {
                        $skipped[] = $device->device_code . ' (not currently on this project)';
                        continue;
                    }
                    $device->update(['status' => 'pending-cancel']);

                    DeviceAndSimClearance::create([
                        'clearance_id' => $clearance->id,
                        'device_id' => $deviceId,
                        'notes' => $request->device_notes[$index] ?? null,
                    ]);
                }
            }

            // Add SIM cards to clearance - only ones actually on this project right now
            if (!empty($request->sim_cards)) {
                foreach ($request->sim_cards as $index => $simId) {
                    $simCard = SimCard::findOrFail($simId);
                    if ((int) $simCard->project_id !== (int) $projectId || $simCard->status !== 'taken') {
                        $skipped[] = $simCard->sim_number . ' (not currently on this project)';
                        continue;
                    }
                    $simCard->update(['status' => 'pending-cancel']);

                    DeviceAndSimClearance::create([
                        'clearance_id' => $clearance->id,
                        'sim_card_id' => $simId,
                        'notes' => $request->sim_notes[$index] ?? null,
                    ]);
                }
            }

            $message = 'Assets added to clearance. Please upload signature to complete.';
            if ($skipped) {
                $message .= ' Skipped: ' . implode(', ', $skipped) . '.';
            }

            return redirect()->route('project-assets.clearance.finish', $clearance->id)
                ->with('success', $message);
        });
    }

    /**
     * Show page to finish clearance (upload signature)
     */
    public function finishClearance($clearanceId)
    {
        $clearance = Clearance::findOrFail($clearanceId);
        $projectId = $clearance->project_id;
        $project = Project::findOrFail($projectId);

        // Get devices and sim cards for this clearance with notes
        $deviceRecords = DeviceAndSimClearance::where('clearance_id', $clearanceId)
            ->whereNotNull('device_id')
            ->with('device')
            ->get();

        $simRecords = DeviceAndSimClearance::where('clearance_id', $clearanceId)
            ->whereNotNull('sim_card_id')
            ->with('simCard')
            ->get();

        return view('project-assets.clearance.finish', compact('clearance', 'deviceRecords', 'simRecords', 'project'));
    }

    /**
     * Complete the clearance process
     */
    public function completeClearance(Request $request, $clearanceId)
    {
        $request->validate([
            'clearing_signature' => 'required|mimes:jpeg,png,jpg,svg,pdf|max:2048',
        ]);

        return DB::transaction(function () use ($request, $clearanceId) {
            $clearance = Clearance::findOrFail($clearanceId);
            $projectId = $clearance->project_id;

            // Upload signature
            if ($request->hasFile('clearing_signature')) {
                $image = $request->file('clearing_signature');
                $imageName = \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('X-Files/Dash/imgs/clearance'), $imageName);

                $clearance->clear_image = $imageName;
                $clearance->status = 'finished';
                $clearance->save();
            }

            // Update all devices and sim cards - make them available
            $deviceRecords = DeviceAndSimClearance::where('clearance_id', $clearanceId)
                ->whereNotNull('device_id')
                ->get();

            foreach ($deviceRecords as $record) {
                Device::where('id', $record->device_id)->update([
                    'status' => 'available',
                    'project_id' => null,
                    'employee_id' => null,
                    'consultant_id' => null,
                    'client_id' => null,
                    'receive_id' => null,
                ]);
            }

            $simRecords = DeviceAndSimClearance::where('clearance_id', $clearanceId)
                ->whereNotNull('sim_card_id')
                ->get();

            foreach ($simRecords as $record) {
                SimCard::where('id', $record->sim_card_id)->update([
                    'status' => 'available',
                    'project_id' => null,
                    'employee_id' => null,
                    'consultant_id' => null,
                    'client_employee_id' => null,
                ]);
            }

            return redirect()->route('project-assets.show', $projectId)
                ->with('success', 'Assets cleared successfully!');
        });
    }

    /**
     * Show form to transfer assets between projects
     */
    public function createTransfer($projectId)
    {
        $project = Project::findOrFail($projectId);

        // Get other active projects
        $otherProjects = Project::where('status', 'in-progress')
            ->where('id', '!=', $projectId)
            ->get();

        // Get devices and sim cards assigned to this project
        $projectDevices = Device::where('project_id', $projectId)
            ->whereIn('status', ['In-Project-Site', 'taken'])
            ->get();

        $projectSimCards = SimCard::where('project_id', $projectId)
            ->where('status', 'taken')
            ->get();

        return view('project-assets.transfer.create', compact('project', 'otherProjects', 'projectDevices', 'projectSimCards'));
    }

    /**
     * Store transfer request
     */
    public function storeTransfer(Request $request, $projectId)
    {
        $request->validate([
            'to_project_id' => 'required|exists:projects,id',
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devices,id',
            'sim_cards' => 'nullable|array',
            'sim_cards.*' => 'exists:sim_cards,id',
            'device_notes' => 'nullable|array',
            'sim_notes' => 'nullable|array',
        ]);

        // Validate against the route's project id, not a client-editable hidden field.
        if ((int) $request->to_project_id === (int) $projectId) {
            return redirect()->back()->with('error', 'Cannot transfer a project\'s assets to itself.');
        }

        if (empty($request->devices) && empty($request->sim_cards)) {
            return redirect()->back()->with('error', 'Please select at least one device or SIM card to transfer.');
        }

        return DB::transaction(function () use ($request, $projectId) {
            $transferCode = ProjectAssetTransfer::generateUniqueCode();
            $skipped = [];

            // Create transfer records for devices - skip anything already mid-transfer elsewhere
            if (!empty($request->devices)) {
                foreach ($request->devices as $index => $deviceId) {
                    if (ProjectAssetTransfer::where('device_id', $deviceId)->where('status', 'pending')->exists()) {
                        $skipped[] = "device #$deviceId (transfer already pending)";
                        continue;
                    }
                    ProjectAssetTransfer::create([
                        'transfer_code' => $transferCode,
                        'from_project_id' => $projectId,
                        'to_project_id' => $request->to_project_id,
                        'device_id' => $deviceId,
                        'notes' => $request->device_notes[$index] ?? null,
                        'status' => 'pending',
                        'transferred_by' => auth()->id(),
                    ]);
                }
            }

            // Create transfer records for SIM cards - same guard
            if (!empty($request->sim_cards)) {
                foreach ($request->sim_cards as $index => $simId) {
                    if (ProjectAssetTransfer::where('sim_card_id', $simId)->where('status', 'pending')->exists()) {
                        $skipped[] = "SIM #$simId (transfer already pending)";
                        continue;
                    }
                    ProjectAssetTransfer::create([
                        'transfer_code' => $transferCode,
                        'from_project_id' => $projectId,
                        'to_project_id' => $request->to_project_id,
                        'sim_card_id' => $simId,
                        'notes' => $request->sim_notes[$index] ?? null,
                        'status' => 'pending',
                        'transferred_by' => auth()->id(),
                    ]);
                }
            }

            // Get the first transfer record to redirect to finish page
            $transfer = ProjectAssetTransfer::where('transfer_code', $transferCode)->first();

            if (!$transfer) {
                return redirect()->back()->with('error', 'Nothing was transferred: ' . implode(', ', $skipped) . '.');
            }

            $message = 'Transfer created. Please upload signature to complete.';
            if ($skipped) {
                $message .= ' Skipped: ' . implode(', ', $skipped) . '.';
            }

            return redirect()->route('project-assets.transfer.finish', $transfer->id)
                ->with('success', $message);
        });
    }

    /**
     * Show page to finish transfer (upload signature)
     */
    public function finishTransfer($transferId)
    {
        $transfer = ProjectAssetTransfer::with(['fromProject', 'toProject'])->findOrFail($transferId);

        // Get all transfers with the same transfer code
        $allTransfers = ProjectAssetTransfer::where('transfer_code', $transfer->transfer_code)
            ->with(['device', 'simCard'])
            ->get();

        return view('project-assets.transfer.finish', compact('transfer', 'allTransfers'));
    }

    /**
     * Complete the transfer process
     */
    public function completeTransfer(Request $request, $transferId)
    {
        $request->validate([
            'transfer_signature' => 'required|mimes:jpeg,png,jpg,svg,pdf|max:2048',
        ]);

        return DB::transaction(function () use ($request, $transferId) {
            $transfer = ProjectAssetTransfer::findOrFail($transferId);

            // Upload signature
            if ($request->hasFile('transfer_signature')) {
                $image = $request->file('transfer_signature');
                $imageName = \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('X-Files/Dash/imgs/transfers'), $imageName);

                // Update all transfers with the same transfer code
                ProjectAssetTransfer::where('transfer_code', $transfer->transfer_code)
                    ->update([
                        'transfer_image' => $imageName,
                        'status' => 'completed',
                        'transferred_at' => now(),
                    ]);
            }

            // Get all transfers with the same code and update assets
            $allTransfers = ProjectAssetTransfer::where('transfer_code', $transfer->transfer_code)->get();

            foreach ($allTransfers as $t) {
                if ($t->device_id) {
                    Device::where('id', $t->device_id)->update([
                        'project_id' => $t->to_project_id,
                    ]);
                }

                if ($t->sim_card_id) {
                    SimCard::where('id', $t->sim_card_id)->update([
                        'project_id' => $t->to_project_id,
                    ]);
                }
            }

            return redirect()->route('project-assets.show', $transfer->to_project_id)
                ->with('success', 'Assets transferred successfully!');
        });
    }

    /**
     * View transfer details
     */
    public function viewTransfer($transferId)
    {
        $transfer = ProjectAssetTransfer::with(['fromProject', 'toProject', 'device', 'simCard', 'transferredBy'])
            ->findOrFail($transferId);

        // Get all transfers with the same transfer code
        $allTransfers = ProjectAssetTransfer::where('transfer_code', $transfer->transfer_code)
            ->with(['device', 'simCard'])
            ->get();

        return view('project-assets.transfer.view', compact('transfer', 'allTransfers'));
    }

    /**
     * True only if nothing currently claims this device - no owner FK set, not already
     * spoken for by a project. Mirrors the filter createReceive() uses to build the
     * "available" picklist, so store*() can't hijack a device the picklist wouldn't show.
     */
    private function deviceIsAvailable(Device $device): bool
    {
        return $device->status === 'available'
            && $device->employee_id === null
            && $device->client_id === null
            && $device->consultant_id === null
            && $device->project_id === null
            && $device->department_id === null;
    }

    private function simCardIsAvailable(SimCard $simCard): bool
    {
        return $simCard->status === 'available'
            && $simCard->employee_id === null
            && $simCard->consultant_id === null
            && $simCard->client_employee_id === null
            && $simCard->project_id === null
            && $simCard->department_id === null;
    }
}
