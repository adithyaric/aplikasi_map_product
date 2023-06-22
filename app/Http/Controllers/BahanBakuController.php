<?php

namespace App\Http\Controllers;

use App\Http\Requests\BahanBakuRequest;
use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Satuan;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahanbakus = BahanBaku::get();

        return view('bahanbaku.index', compact('bahanbakus'));
    }

    public function create()
    {
        return view('bahanbaku.create', [
            'categories' => Category::get(),
            'satuans' => Satuan::get(),
        ]);
    }

    public function store(BahanBakuRequest $request)
    {
        $data = $request->validated();
        BahanBaku::create($data);

        return redirect(route('bahanbaku.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(BahanBaku $bahanBaku)
    {
        dd($bahanBaku);
    }

    public function edit($bahanBaku)
    {
        return view('bahanbaku.edit', [
            'categories' => Category::get(),
            'satuans' => Satuan::get(),
            'bahanBaku' => BahanBaku::find($bahanBaku),
        ]);
    }

    public function update(BahanBakuRequest $request, $bahanBaku)
    {
        $data = $request->validated();
        $bahanBaku = BahanBaku::find($bahanBaku);
        $bahanBaku->update($data);

        return redirect(route('bahanbaku.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy($bahanBaku)
    {
        $bahanBaku = BahanBaku::find($bahanBaku);
        $bahanBaku->delete();

        return redirect(route('bahanbaku.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
