<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::get();

        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(CustomerRequest $request)
    {
        $data = $request->validated();
        Customer::create($data);

        return redirect(route('customer.index'))->with('toast_success', 'Berhasil Menyimpan Data!');

    }

    public function show(Customer $customer)
    {
        dd($customer);
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();
        $customer->update($data);

        return redirect(route('customer.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect(route('customer.index'))->with('toast_error', 'Berhasil Menghapus Data!');

    }
}
