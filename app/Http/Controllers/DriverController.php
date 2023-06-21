<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::get();

        return view('driver.index', compact('drivers'));
    }

    public function create()
    {
        return view('driver.create');
    }

    public function store(DriverRequest $request)
    {
        $data = $request->validated();
        Driver::create($data);

        return redirect(route('driver.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Driver $driver)
    {
        dd($driver);
    }

    public function edit(Driver $driver)
    {
        return view('driver.edit', compact('driver'));
    }

    public function update(DriverRequest $request, Driver $driver)
    {
        $data = $request->validated();
        $driver->update($data);

        return redirect(route('driver.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect(route('driver.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
