<?php

namespace App\Http\Controllers;

use App\Http\Requests\SatuanRequest;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Satuan::get();

        return view('satuan.index', compact('satuans'));
    }

    public function create()
    {
        return view('satuan.create');
    }

    public function store(SatuanRequest $request)
    {
        $data = $request->validated();
        Satuan::create($data);

        return redirect(route('satuan.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Satuan $satuan)
    {
        dd($satuan);
    }

    public function edit(Satuan $satuan)
    {
        return view('satuan.edit', compact('satuan'));
    }

    public function update(SatuanRequest $request, Satuan $satuan)
    {
        $data = $request->validated();
        $satuan->update($data);

        return redirect(route('satuan.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        return redirect(route('satuan.index'))->with('toast_error', 'Berhasil Menghapus Data!');

    }
}
