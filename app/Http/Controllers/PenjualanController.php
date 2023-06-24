<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenjualanRequest;
use App\Models\Customer;
use App\Models\Penjualan;
use App\Models\Product;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::get();

        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        return view('penjualan.create', [
            'customers' => Customer::get(),
            'products' => Product::get(),
        ]);
    }

    public function store(PenjualanRequest $request)
    {
        $data = $request->validated();
        Penjualan::create($data);

        return redirect(route('penjualan.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Penjualan $penjualan)
    {
        dd($penjualan);
    }

    public function edit(Penjualan $penjualan)
    {
        return view('penjualan.edit', [
            'penjualan' => $penjualan,
            'customers' => Customer::get(),
            'products' => Product::get(),
        ]);
    }

    public function update(PenjualanRequest $request, Penjualan $penjualan)
    {
        $data = $request->validated();
        $penjualan->update($data);

        return redirect(route('penjualan.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();

        return redirect(route('penjualan.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
