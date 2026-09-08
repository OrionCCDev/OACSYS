<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\Consultant;
use App\Models\ClientEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrinterController extends Controller
{
    /**
     * Report of every printer - active ones by default, since a project's
     * transferred/cancelled printers are still visible via history but
     * shouldn't clutter the day-to-day view.
     */
    public function index(Request $request)
    {
        $query = Printer::with(['project', 'supplier', 'clientEmployee', 'consultant']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('po_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', fn ($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        // "deleted" is not one of the status column's values - it is the
        // soft-delete state, so it selects a different set of rows entirely.
        $status = $request->input('status', 'active');
        if ($status === 'deleted') {
            $query->onlyTrashed();
        } elseif ($status !== 'all') {
            $query->where('status', $status);
        }

        $printers = $query->orderByDesc('start_date')->paginate(15)->withQueryString();

        return view('printers.index', compact('printers'));
    }

    /**
     * Single printer: current delivery/location, its PO, its full transfer
     * chain, and every invoice raised against it.
     */
    public function show(Printer $printer)
    {
        $printer->load([
            'project', 'supplier', 'clientEmployee', 'consultant', 'invoices',
            'transferredFrom.project', 'transferredTo.project',
        ]);

        $projects = Project::where('status', 'in-progress')->where('id', '!=', $printer->project_id)->orderBy('project_name')->get();
        $clientEmployees = ClientEmployee::orderBy('name')->get();
        $consultants = Consultant::orderBy('name')->get();

        return view('printers.show', compact('printer', 'projects', 'clientEmployees', 'consultants'));
    }

    /**
     * Form to receive a new printer (against its ERP PO). Reachable straight
     * from the printers report with no project chosen yet, or from a project's
     * own page - which passes the project through to pre-select it.
     */
    public function create(?Project $project = null)
    {
        $projects = Project::where('status', 'in-progress')->orderBy('project_name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $clientEmployees = ClientEmployee::orderBy('name')->get();
        $consultants = Consultant::orderBy('name')->get();

        return view('printers.create', compact('project', 'projects', 'suppliers', 'clientEmployees', 'consultants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'po_number' => 'required|string|max:255',
            'po_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
            'name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'size' => 'required|in:big,small',
            'designation' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delivered_to_type' => 'required|in:client,consultant,office',
            'target_id' => 'nullable|integer|required_unless:delivered_to_type,office',
            'start_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        [$targetId, $error] = $this->resolveDeliveryTarget($validated['delivered_to_type'], $validated['target_id'] ?? null);
        if ($error) {
            return redirect()->back()->withInput()->with('error', $error);
        }

        $printer = Printer::create([
            'project_id' => $validated['project_id'],
            'supplier_id' => $validated['supplier_id'] ?? null,
            'po_number' => $validated['po_number'],
            'name' => $validated['name'],
            'model' => $validated['model'] ?? null,
            'size' => $validated['size'],
            'designation' => $validated['designation'] ?? null,
            'serial_number' => $validated['serial_number'] ?? null,
            'delivered_to_type' => $validated['delivered_to_type'],
            'client_employee_id' => $validated['delivered_to_type'] === 'client' ? $targetId : null,
            'consultant_id' => $validated['delivered_to_type'] === 'consultant' ? $targetId : null,
            'status' => 'active',
            'start_date' => $validated['start_date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($request->hasFile('po_document')) {
            $printer->update(['po_document' => $this->storeUpload($request->file('po_document'), 'printers/po')]);
        }

        if ($request->hasFile('main_image')) {
            $printer->update(['main_image' => $this->storeUpload($request->file('main_image'), 'devices')]);
        }

        return redirect()->route('printers.show', $printer->id)->with('success', 'Printer received onto this project.');
    }

    /**
     * Correct a printer's details. This is a data-entry fix, not a lifecycle
     * action - moving a printer to a new project under a new PO is Transfer,
     * which keeps the chain; ending its rental is Cancel.
     */
    public function edit(Printer $printer)
    {
        $projects = Project::orderBy('project_name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $clientEmployees = ClientEmployee::orderBy('name')->get();
        $consultants = Consultant::orderBy('name')->get();

        return view('printers.edit', compact('printer', 'projects', 'suppliers', 'clientEmployees', 'consultants'));
    }

    public function update(Request $request, Printer $printer)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'po_number' => 'required|string|max:255',
            'po_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
            'name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'size' => 'required|in:big,small',
            'designation' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delivered_to_type' => 'required|in:client,consultant,office',
            'target_id' => 'nullable|integer|required_unless:delivered_to_type,office',
            'start_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        [$targetId, $error] = $this->resolveDeliveryTarget($validated['delivered_to_type'], $validated['target_id'] ?? null);
        if ($error) {
            return redirect()->back()->withInput()->with('error', $error);
        }

        $printer->update([
            'project_id' => $validated['project_id'],
            'supplier_id' => $validated['supplier_id'] ?? null,
            'po_number' => $validated['po_number'],
            'name' => $validated['name'],
            'model' => $validated['model'] ?? null,
            'size' => $validated['size'],
            'designation' => $validated['designation'] ?? null,
            'serial_number' => $validated['serial_number'] ?? null,
            'delivered_to_type' => $validated['delivered_to_type'],
            'client_employee_id' => $validated['delivered_to_type'] === 'client' ? $targetId : null,
            'consultant_id' => $validated['delivered_to_type'] === 'consultant' ? $targetId : null,
            'start_date' => $validated['start_date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Replace uploads only when a new file is supplied, and clear the old
        // one off disk so replacements don't pile up.
        if ($request->hasFile('po_document')) {
            $old = $printer->po_document;
            $printer->update(['po_document' => $this->storeUpload($request->file('po_document'), 'printers/po')]);
            $this->deleteUpload($old, 'printers/po');
        }

        if ($request->hasFile('main_image')) {
            $old = $printer->main_image;
            $printer->update(['main_image' => $this->storeUpload($request->file('main_image'), 'devices')]);
            $this->deleteUpload($old, 'devices');
        }

        return redirect()->route('printers.show', $printer->id)->with('success', 'Printer updated.');
    }

    /**
     * Remove a printer from the listings. This is a soft delete: the row, its
     * invoices and its documents all stay put, so a record deleted by mistake
     * can be restored intact. Deleted printers are reachable through the
     * report's "Deleted" filter.
     */
    public function destroy(Printer $printer)
    {
        $printer->delete();

        return redirect()->route('printers.index')
            ->with('success', 'Printer deleted. You can restore it from the Deleted filter.');
    }

    /** Put a soft-deleted printer back into service. */
    public function restore(int $printerId)
    {
        $printer = Printer::onlyTrashed()->findOrFail($printerId);
        $printer->restore();

        return redirect()->route('printers.show', $printer->id)->with('success', 'Printer restored.');
    }

    /**
     * Erase a soft-deleted printer for good, with its invoices (cascaded by
     * the database) and every uploaded document. Nothing here is recoverable,
     * so it is only reachable for a printer that is already deleted.
     */
    public function forceDestroy(int $printerId)
    {
        $printer = Printer::onlyTrashed()->with('invoices')->findOrFail($printerId);

        foreach ($printer->invoices as $invoice) {
            $this->deleteUpload($invoice->invoice_document, 'printers/invoices');
        }

        $this->deleteUpload($printer->po_document, 'printers/po');
        $this->deleteUpload($printer->main_image, 'devices');

        $printer->forceDelete();

        return redirect()->route('printers.index', ['status' => 'deleted'])
            ->with('success', 'Printer permanently deleted.');
    }

    /**
     * Move the printer between client/consultant/office within the same
     * project - no new PO, no history entry, just where it physically is.
     */
    public function updateDelivery(Request $request, Printer $printer)
    {
        $validated = $request->validate([
            'delivered_to_type' => 'required|in:client,consultant,office',
            'target_id' => 'nullable|integer|required_unless:delivered_to_type,office',
        ]);

        [$targetId, $error] = $this->resolveDeliveryTarget($validated['delivered_to_type'], $validated['target_id'] ?? null);
        if ($error) {
            return redirect()->back()->with('error', $error);
        }

        $printer->update([
            'delivered_to_type' => $validated['delivered_to_type'],
            'client_employee_id' => $validated['delivered_to_type'] === 'client' ? $targetId : null,
            'consultant_id' => $validated['delivered_to_type'] === 'consultant' ? $targetId : null,
        ]);

        return redirect()->back()->with('success', 'Delivery location updated.');
    }

    /**
     * Move the printer's rental on to a new project under a new PO - closes
     * this record and creates the new project's printer record.
     */
    public function transfer(Request $request, Printer $printer)
    {
        if ($printer->status !== 'active') {
            return redirect()->back()->with('error', 'Only an active printer can be transferred.');
        }

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'po_number' => 'required|string|max:255',
            'po_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
            'delivered_to_type' => 'required|in:client,consultant,office',
            'target_id' => 'nullable|integer|required_unless:delivered_to_type,office',
            'start_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ((int) $validated['project_id'] === (int) $printer->project_id) {
            return redirect()->back()->with('error', 'Choose a different project to transfer to.');
        }

        [$targetId, $error] = $this->resolveDeliveryTarget($validated['delivered_to_type'], $validated['target_id'] ?? null);
        if ($error) {
            return redirect()->back()->with('error', $error);
        }

        $poDocument = $request->hasFile('po_document')
            ? $this->storeUpload($request->file('po_document'), 'printers/po')
            : null;

        $newPrinter = $printer->transferToProject(
            (int) $validated['project_id'],
            $validated['po_number'],
            $validated['delivered_to_type'],
            $targetId,
            $validated['start_date'],
            $poDocument,
            $validated['notes'] ?? null
        );

        return redirect()->route('printers.show', $newPrinter->id)->with('success', 'Printer transferred to the new project.');
    }

    /**
     * End the printer's rental - returned to the supplier, not continuing
     * anywhere.
     */
    public function cancel(Request $request, Printer $printer)
    {
        if ($printer->status !== 'active') {
            return redirect()->back()->with('error', 'Only an active printer can be cancelled.');
        }

        $validated = $request->validate([
            'end_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $printer->cancel($validated['end_date'], $validated['notes'] ?? null);

        return redirect()->route('printers.show', $printer->id)->with('success', 'Printer rental cancelled.');
    }

    public function storeInvoice(Request $request, Printer $printer)
    {
        $validated = $request->validate([
            'num' => 'required|string|max:255',
            'released_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_term' => 'nullable|string|max:255',
            'invoice_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        $invoice = Invoice::create([
            'printer_id' => $printer->id,
            'num' => $validated['num'],
            'released_date' => $validated['released_date'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'payment_term' => $validated['payment_term'] ?? null,
        ]);

        if ($request->hasFile('invoice_document')) {
            $invoice->update(['invoice_document' => $this->storeUpload($request->file('invoice_document'), 'printers/invoices')]);
        }

        return redirect()->route('printers.show', $printer->id)->with('success', 'Invoice added.');
    }

    /**
     * Correct an invoice in place. Its dates are what the billing-coverage
     * reports read, so a mistyped period shows up there as a false gap or a
     * false double-billing - fixing that shouldn't cost you the attached
     * document, which is what deleting and re-adding used to mean.
     */
    public function updateInvoice(Request $request, Invoice $invoice)
    {
        if ($this->invoiceLocked($invoice)) {
            return redirect()->route('printers.show', $invoice->printer_id)
                ->with('error', 'This printer is deleted. Restore it before changing its invoices.');
        }

        $validated = $request->validate([
            'num' => 'required|string|max:255',
            'released_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_term' => 'nullable|string|max:255',
            'invoice_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        $invoice->update([
            'num' => $validated['num'],
            'released_date' => $validated['released_date'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'payment_term' => $validated['payment_term'] ?? null,
        ]);

        // Replace the document only when a new one is supplied, and clear the
        // old file so replacements don't pile up on disk.
        if ($request->hasFile('invoice_document')) {
            $old = $invoice->invoice_document;
            $invoice->update(['invoice_document' => $this->storeUpload($request->file('invoice_document'), 'printers/invoices')]);
            $this->deleteUpload($old, 'printers/invoices');
        }

        return redirect()->route('printers.show', $invoice->printer_id)->with('success', 'Invoice updated.');
    }

    public function destroyInvoice(Invoice $invoice)
    {
        if ($this->invoiceLocked($invoice)) {
            return redirect()->route('printers.show', $invoice->printer_id)
                ->with('error', 'This printer is deleted. Restore it before changing its invoices.');
        }

        $printerId = $invoice->printer_id;

        // The row goes, so its document has to go with it - nothing will ever
        // reference the file again.
        $this->deleteUpload($invoice->invoice_document, 'printers/invoices');
        $invoice->delete();

        return redirect()->route('printers.show', $printerId)->with('success', 'Invoice removed.');
    }

    /**
     * Invoices bind by their own id, so unlike the printer routes they stay
     * reachable when their printer is soft-deleted. A deleted printer is
     * read-only, so its invoices are too.
     */
    private function invoiceLocked(Invoice $invoice): bool
    {
        return Printer::withTrashed()->find($invoice->printer_id)?->trashed() ?? false;
    }

    /**
     * @return array{0: ?int, 1: ?string} [targetId, errorMessage]
     */
    private function resolveDeliveryTarget(string $type, ?int $targetId): array
    {
        $targetId = $type === 'office' ? null : $targetId;

        $exists = match ($type) {
            'client' => ClientEmployee::where('id', $targetId)->exists(),
            'consultant' => Consultant::where('id', $targetId)->exists(),
            'office' => true,
        };

        return $exists ? [$targetId, null] : [null, 'The selected delivery destination could not be found.'];
    }

    private function storeUpload($file, string $subfolder): string
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('X-Files/Dash/imgs/' . $subfolder), $fileName);

        return $fileName;
    }

    /** Never removes the shared placeholder image. */
    private function deleteUpload(?string $fileName, string $subfolder): void
    {
        if (!$fileName || $fileName === 'default_device.png') {
            return;
        }

        $path = public_path('X-Files/Dash/imgs/' . $subfolder . '/' . $fileName);
        if (is_file($path)) {
            unlink($path);
        }
    }
}
