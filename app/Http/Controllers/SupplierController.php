<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $categoires = Supplier::get();

        return view('supplier.index', compact('categoires'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(SupplierRequest $request)
    {
        $data = $request->validated();
        Supplier::create($data);

        return redirect(route('supplier.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Supplier $supplier)
    {
        dd($supplier);
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();
        $supplier->update($data);

        return redirect(route('supplier.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect(route('supplier.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
