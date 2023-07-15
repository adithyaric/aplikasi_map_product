<?php

namespace App\Http\Controllers;

use App\Http\Requests\TruckRequest;
use App\Models\Truck;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::get();

        return view('truck.index', compact('trucks'));
    }

    public function create()
    {
        return view('truck.create');
    }

    public function store(TruckRequest $request)
    {
        $data = $request->validated();
        Truck::create($data);

        return redirect(route('truck.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Truck $truck)
    {
        dd($truck);
    }

    public function edit(Truck $truck)
    {
        return view('truck.edit', compact('truck'));
    }

    public function update(TruckRequest $request, Truck $truck)
    {
        $data = $request->validated();
        $truck->update($data);

        return redirect(route('truck.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Truck $truck)
    {
        $truck->delete();

        return redirect(route('truck.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
