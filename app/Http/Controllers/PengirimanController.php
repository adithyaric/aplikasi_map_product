<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengirimanRequest;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Pengiriman;
use App\Models\Penjualan;
use App\Models\Project;
use Illuminate\Http\Request;

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
            'penjualans' => Penjualan::get(),
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
            'penjualans' => Penjualan::get(),
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

    public function solar(Request $request)
    {
        return view('pengiriman.solar', [
            'pengiriman' => Pengiriman::find($request->pengiriman_id),
        ]);
    }

    public function solarUpdate(Request $request, Pengiriman $pengiriman)
    {
        $pengiriman->solar = $request->solar;
        $pengiriman->status = 'selesai';
        $pengiriman->save();

        return redirect(route('pengiriman.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }
}
