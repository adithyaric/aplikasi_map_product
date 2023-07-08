<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenjualanRequest;
use App\Models\Customer;
use App\Models\Penjualan;
use App\Models\Product;
use App\Models\Project;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::get();

        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $no_invoice = Penjualan::count() + 1;
        $formatted_no_invoice = str_pad($no_invoice, 4, '0', STR_PAD_LEFT);

        return view('penjualan.create', [
            'customers' => Customer::get(),
            'products' => Product::get(),
            'projects' => Project::get(),
            'formatted_no_invoice' => $formatted_no_invoice,
        ]);
    }

    public function store(PenjualanRequest $request)
    {
        $project = Project::find($request->project_id);
        $data = $request->validated();
        Penjualan::create($data);
        foreach ($project->product->bahanbaku as $bahanbaku) {
            $bahanbaku->decrement('stock');
        }

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
            'projects' => Project::get(),
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
