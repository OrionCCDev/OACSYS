<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceAndSimReceive;
use App\Models\Employee;
use App\Models\Receive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * A receiving for somebody who is not in the system yet.
 *
 * A new joiner is often handed a laptop before HR has registered them.
 * Rather than hold the handover up, this records them with the three
 * things we can ask on the spot - full name, personal email, mobile - as an
 * employee marked "not registered yet", and raises an ordinary receiving
 * for the laptop or PC. Because it is an ordinary receiving, the company
 * form, the signed upload and a later clearance all work as usual, and HR
 * completes the employee's record when they get to it.
 */
class NewEmployeeReceiveController extends Controller
{
    /** The error bag, so a rejected popup can reopen itself with its messages. */
    public const BAG = 'newEmployeeReceive';

    public const KINDS = ['laptop' => 'Laptop', 'pc' => 'PC'];

    /**
     * Which of the two a device is, going by its type as typed in the
     * inventory ("Laptop", "laptop Dell", "Pc", "Desktop PC"...).
     */
    public static function kindOf(?string $deviceType): ?string
    {
        $type = strtolower(trim((string) $deviceType));

        if ($type === '') {
            return null;
        }
        if (str_contains($type, 'laptop') || str_contains($type, 'notebook')) {
            return 'laptop';
        }
        if (preg_match('/\b(pc|desktop|workstation)\b/', $type) || str_contains($type, 'all in one') || str_contains($type, 'all-in-one')) {
            return 'pc';
        }

        return null;
    }

    /** Laptops and PCs that are free to hand over, each tagged with its kind. */
    public static function availableDevices()
    {
        return Device::query()
            ->where('status', 'available')
            ->whereNull('employee_id')
            ->whereNull('client_id')
            ->whereNull('consultant_id')
            ->orderBy('device_code')
            ->get()
            ->map(function (Device $device) {
                $device->kind = self::kindOf($device->device_type);

                return $device;
            })
            ->filter(fn (Device $device) => $device->kind !== null)
            ->values();
    }

    public function store(Request $request)
    {
        $data = $request->validateWithBag(self::BAG, [
            'full_name' => 'required|string|min:3|max:255',
            'personal_email' => 'required|email|max:255',
            'mobile' => ['required', 'string', 'max:30', 'regex:/^\+?[0-9][0-9 \-]{6,}$/'],
            'item_type' => 'required|in:' . implode(',', array_keys(self::KINDS)),
            'device_id' => 'required|integer|exists:devices,id',
        ], [
            'mobile.regex' => 'Enter the mobile number in digits, for example 0501234567 or +971501234567.',
            'device_id.required' => 'Choose which device is being handed over.',
        ], [
            'full_name' => 'full name',
            'personal_email' => 'personal email',
            'device_id' => 'device',
            'item_type' => 'type',
        ]);

        $name = trim(preg_replace('/\s+/', ' ', $data['full_name']));
        $email = strtolower(trim($data['personal_email']));

        // Somebody already in the system gets an ordinary receiving, not a
        // second record of themselves.
        $existing = Employee::whereRaw('LOWER(personal_email) = ?', [$email])
            ->orWhereRaw('LOWER(orion_email) = ?', [$email])
            ->first();
        if ($existing) {
            throw ValidationException::withMessages([
                'personal_email' => $existing->name . ' is already in the system with this email'
                    . ($existing->employee_id ? ' (ID ' . $existing->employee_id . ')' : '')
                    . '. Use Make Receiving > Create for them.',
            ])->errorBag(self::BAG);
        }

        $receive = DB::transaction(function () use ($data, $name, $email) {
            // Locked, so two people cannot hand the same laptop to two joiners.
            $device = Device::whereKey($data['device_id'])->lockForUpdate()->first();

            if (!$device || $device->status !== 'available'
                || $device->employee_id !== null || $device->client_id !== null || $device->consultant_id !== null) {
                throw ValidationException::withMessages([
                    'device_id' => 'That device is no longer available. Choose another one.',
                ])->errorBag(self::BAG);
            }
            if (self::kindOf($device->device_type) !== $data['item_type']) {
                throw ValidationException::withMessages([
                    'device_id' => 'That device is not a ' . self::KINDS[$data['item_type']] . '.',
                ])->errorBag(self::BAG);
            }

            $employee = Employee::create([
                'name' => $name,
                'personal_email' => $email,
                'personal_mobile' => trim($data['mobile']),
                'type' => 'employee',
                'registration_pending' => true,
            ]);

            $receive = Receive::create([
                'status' => 'pending',
                'employee_id' => $employee->id,
            ]);

            DeviceAndSimReceive::create([
                'receive_id' => $receive->id,
                'device_id' => $device->id,
            ]);

            // The same state an ordinary receiving leaves a chosen device in.
            $device->update([
                'status' => 'pending-receiving',
                'employee_id' => $employee->id,
            ]);

            return $receive;
        });

        return redirect()->route('receive.show', $receive->id)
            ->with('success', 'Receiving ' . $receive->code . ' made for ' . $name . '. Print the form for them to sign.');
    }
}
