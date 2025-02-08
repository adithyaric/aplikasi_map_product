<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use App\Models\RequestInput;
use Illuminate\Http\Request;

class RequestInputController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:0',
            // 'requested_at' => 'required|date',
        ]);

        $filteredProducts = collect($validatedData['product_id'])
            ->zip($validatedData['quantity'])
            ->filter(fn ($pair) => $pair[1] > 0)
            ->map(fn ($pair) => ['product_id' => $pair[0], 'quantity' => $pair[1]])
            ->values();

        if ($filteredProducts->isEmpty()) {
            return redirect()->back()->withErrors(['quantity' => 'Minimal satu produk harus memiliki jumlah lebih dari 0.']);
        }

        $data = RequestInput::create([
            'user_id' => $validatedData['user_id'],
            'location_id' => $validatedData['location_id'],
            'products' => $filteredProducts,
            // 'requested_at' => $validatedData['requested_at'],
            'status' => 'waiting',
        ]);

        // dd($data->toArray());
        return redirect(route('product.input.form'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function approve(RequestInput $requestInput)
    {
        if ($requestInput->status !== 'waiting') {
            return redirect()->back()->withErrors(['error' => 'Permintaan sudah diproses sebelumnya.']);
        }

        // Fetch the dusun location and traverse up the hierarchy
        $dusun = Location::findOrFail($requestInput->location_id);
        $desa = $dusun->parent;
        $kecamatan = $desa?->parent;
        $kabupaten = $kecamatan?->parent;
        $provinsi = $kabupaten?->parent;

        foreach ($requestInput->products as $product) {
            Product::findOrFail($product['product_id'])
                ->locations()
                ->attach($requestInput->location_id, [
                    'user_id' => $requestInput->user_id,
                    'quantity' => $product['quantity'],
                    'date' => $requestInput->requested_at,
                    'location_dusun_id' => $requestInput->location_id,
                    'location_desa_id' => $desa?->id,
                    'location_kecamatan_id' => $kecamatan?->id,
                    'location_kabupaten_id' => $kabupaten?->id,
                    'location_provinsi_id' => $provinsi?->id,
                ]);
        }

        $requestInput->update(['status' => 'approved']);

        // dd($requestInput->toArray());
        return redirect(route('product.input.history'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }
}
