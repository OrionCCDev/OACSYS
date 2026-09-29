<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Closing a receive or clearance normally means uploading the signed paper.
 * This lets the same action close it with no paper at all, when the form
 * asks for that ("force close").
 *
 * It is the same action on purpose. Every kind of receive and clearance
 * does something different to its devices and SIM cards when it closes;
 * going through the one method means a forced close does exactly what a
 * normal close does, minus the file.
 */
trait ClosesWithoutDocument
{
    /** Roles allowed to close a record with no signed paper. */
    protected array $forceCloseRoles = ['o-admin', 'o-super-admin'];

    /**
     * Validate the closing request and say whether it is a forced close.
     * The file is required unless it is.
     */
    protected function validateClosing(Request $request, string $field, string $mimes, array $extraRules = []): bool
    {
        $forced = $request->boolean('force_close');

        if ($forced) {
            abort_unless(
                (bool) $request->user()?->hasRole($this->forceCloseRoles),
                403,
                'Only an administrator can close this without a signed document.'
            );
        }

        $request->validate($extraRules + [
            $field => ($forced ? 'nullable' : 'required') . '|mimes:' . $mimes . '|max:2048',
            'force_close_reason' => 'nullable|string|max:500',
        ]);

        return $forced;
    }

    /**
     * What to write on the record to close it: the stored file, or the note
     * that it was closed without one.
     */
    protected function closingAttributes(Request $request, bool $forced, string $field, string $column, string $folder, string $status): array
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $name = Str::uuid() . '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $file->move(public_path('X-Files/Dash/imgs/' . $folder), $name);

            return [$column => $name, 'status' => $status];
        }

        abort_unless($forced, 422, 'A signed document is required.');

        $reason = trim((string) $request->input('force_close_reason'));

        return [
            'status' => $status,
            'force_closed_at' => now(),
            'force_closed_by' => $request->user()->id,
            'force_close_reason' => $reason === '' ? null : $reason,
        ];
    }
}
