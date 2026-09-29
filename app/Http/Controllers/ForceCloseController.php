<?php

namespace App\Http\Controllers;

use App\Models\Clearance;
use App\Models\DeviceAndSimClearance;
use App\Models\DeviceAndSimReceive;
use App\Models\Device;
use App\Models\Receive;
use App\Models\SimCard;
use Illuminate\Http\Request;

/**
 * Force close from the lists and the record pages.
 *
 * Those places know the record but not which flow made it, and each flow
 * closes differently: a project receive puts devices on site, a department
 * one marks them taken, a transfer hands them to the new employee, a
 * resignation also resigns the employee. So this works out which flow the
 * record belongs to and hands over to that flow's own closing action, with
 * "force close" switched on. Nothing about closing is decided here.
 */
class ForceCloseController extends Controller
{
    public function receive(Request $request, Receive $receive)
    {
        if ($receive->status === 'received') {
            return back()->with('error', 'Receive ' . $receive->code . ' is already closed.');
        }

        $request->merge(['force_close' => 1]);

        if ($receive->project_id) {
            app(ProjectAssetController::class)->completeReceive($request, $receive->id);
        } elseif ($receive->department_id) {
            app(DepartmentAssetController::class)->completeReceive($request, $receive->id);
        } elseif ($this->isTransferReceive($receive)) {
            app(DeviceTransferController::class)->completeReceive($request, $receive);
        } else {
            app(ReceiveController::class)->finish($receive->id, $request);
        }

        return back()->with('success', 'Receive ' . $receive->code . ' closed without a signed document.');
    }

    public function clearance(Request $request, Clearance $clearance)
    {
        if (in_array($clearance->status, ['finished', 'resigned'])) {
            return back()->with('error', 'Clearance ' . $clearance->clear_code . ' is already closed.');
        }

        $request->merge(['force_close' => 1]);

        if ($clearance->status === 'pending_resign') {
            if (!$clearance->employee_id) {
                return back()->with('error', 'This resignation clearance has no employee on it, so it cannot be completed.');
            }
            app(EmployeeController::class)->finishResign($clearance->employee_id, $clearance->id, $request);
        } elseif ($clearance->project_id) {
            app(ProjectAssetController::class)->completeClearance($request, $clearance->id);
        } elseif ($clearance->department_id) {
            app(DepartmentAssetController::class)->completeClearance($request, $clearance->id);
        } elseif ($this->isTransferClearance($clearance)) {
            app(DeviceTransferController::class)->completeClearance($request, $clearance);
        } else {
            app(ClearanceController::class)->uploadSignature($request, $clearance->id);
        }

        return back()
            ->with('success', 'Clearance ' . $clearance->clear_code . ' closed without a signed document.')
            // the clearance page announces results through this key
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Closed',
                'text' => 'Clearance ' . $clearance->clear_code . ' closed without a signed document.',
            ]);
    }

    /**
     * The receiving half of a transfer between two employees: what is on
     * it is still held, reserved, by somebody else.
     */
    private function isTransferReceive(Receive $receive): bool
    {
        if (!$receive->employee_id) {
            return false;
        }

        $records = DeviceAndSimReceive::where('receive_id', $receive->id)->get();

        $heldByAnother = fn ($query) => $query
            ->where('status', 'pending-cancel')
            ->whereNotNull('employee_id')
            ->where('employee_id', '!=', $receive->employee_id)
            ->exists();

        return $heldByAnother(Device::whereIn('id', $records->pluck('device_id')->filter()))
            || $heldByAnother(SimCard::whereIn('id', $records->pluck('sim_card_id')->filter()));
    }

    /**
     * The releasing half of a transfer. A transfer writes its clearance and
     * its receive together, for the same items, to a different employee.
     * Closing this half must not release the items - they are on their way
     * to (or already with) the new employee.
     */
    private function isTransferClearance(Clearance $clearance): bool
    {
        if (!$clearance->employee_id || !$clearance->created_at) {
            return false;
        }

        $records = DeviceAndSimClearance::where('clearance_id', $clearance->id)->get();
        $deviceIds = $records->pluck('device_id')->filter();
        $simIds = $records->pluck('sim_card_id')->filter();

        if ($deviceIds->isEmpty() && $simIds->isEmpty()) {
            return false;
        }

        return Receive::query()
            ->whereNotNull('employee_id')
            ->where('employee_id', '!=', $clearance->employee_id)
            ->whereBetween('created_at', [
                $clearance->created_at->copy()->subSeconds(30),
                $clearance->created_at->copy()->addSeconds(30),
            ])
            ->whereIn('id', DeviceAndSimReceive::query()
                ->where(function ($q) use ($deviceIds, $simIds) {
                    $q->whereIn('device_id', $deviceIds)->orWhereIn('sim_card_id', $simIds);
                })
                ->select('receive_id'))
            ->exists();
    }
}
