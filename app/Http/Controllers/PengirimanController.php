<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengirimanRequest;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Pengiriman;
use App\Models\Project;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengirimans = Pengiriman::get();

        return view('pengiriman.index', compact('pengirimans'));
    }

    public function create()
    {
        return view('pengiriman.create', [
            'customers' => Customer::get(),
            'drivers' => Driver::get(),
            'projects' => Project::get(),
        ]);
    }

    public function store(PengirimanRequest $request)
    {
        $data = $request->validated();
        Pengiriman::create($data);

        return redirect(route('pengiriman.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Pengiriman $pengiriman)
    {
        dd($pengiriman);
    }

    public function edit(Pengiriman $pengiriman)
    {
        return view('pengiriman.edit', [
            'pengiriman' => $pengiriman,
            'customers' => Customer::get(),
            'drivers' => Driver::get(),
            'projects' => Project::get(),
        ]);
    }

    public function update(PengirimanRequest $request, Pengiriman $pengiriman)
    {
        $data = $request->validated();
        $pengiriman->update($data);

        return redirect(route('pengiriman.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Pengiriman $pengiriman)
    {
        $pengiriman->delete();

        return redirect(route('pengiriman.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
