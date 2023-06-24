<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembelianRequest;
use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Pembelian;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::get();

        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        return view('pembelian.create', [
            'bahan_bakus' => BahanBaku::get(),
            'categories' => Category::get(),
        ]);
    }

    public function store(PembelianRequest $request)
    {
        $data = $request->validated();
        Pembelian::create($data);

        return redirect(route('pembelian.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Pembelian $pembelian)
    {
        dd($pembelian);
    }

    public function edit(Pembelian $pembelian)
    {
        return view('pembelian.edit', [
            'pembelian' => $pembelian,
            'bahan_bakus' => BahanBaku::get(),
            'categories' => Category::get(),
        ]);
    }

    public function update(PembelianRequest $request, Pembelian $pembelian)
    {
        $data = $request->validated();
        $pembelian->update($data);

        return redirect(route('pembelian.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();

        return redirect(route('pembelian.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
