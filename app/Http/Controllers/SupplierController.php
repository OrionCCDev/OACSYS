<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('printers')->orderBy('name')->paginate(15);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trn_number' => 'nullable|string|max:255',
            'responsible_mobile' => 'nullable|string|max:255',
            'responsible_email' => 'nullable|email|max:255',
            'global_email' => 'nullable|email|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        Supplier::create($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier added successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trn_number' => 'nullable|string|max:255',
            'responsible_mobile' => 'nullable|string|max:255',
            'responsible_email' => 'nullable|email|max:255',
            'global_email' => 'nullable|email|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $supplier->update($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->printers()->exists()) {
            return redirect()->back()->with('error', 'This supplier has printers linked to it and cannot be deleted.');
        }

        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier deleted.');
    }
}
