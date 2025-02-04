<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();

        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create', [
            // 'bahanbakus' => BahanBaku::get(),
            // 'categories' => Category::get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Product::create(['name' => $data['name']]);

        return redirect(route('product.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Product $product)
    {
        dd($product);
    }

    public function edit(Product $product)
    {
        return view('product.edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $product->update(['name' => $data['name']]);

        return redirect(route('product.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect(route('product.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }

    public function showInputForm()
    {
        $authUser = auth()->user();

        // If user is admin, show users with role 'sales', otherwise show only the logged-in user
        $users = $authUser->role === 'admin'
            ? User::where('role', 'sales')->get()
            : User::where('id', $authUser->id)->get();

        // $locations = Location::whereIn('type', ['desa', 'dusun'])->get();

        $products = Product::get();

        return view('inputpenyebaran', compact('users', 'products'));
    }

    public function inputProductQuantity(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:0', // Allow 0, but we'll filter it later
            'created_at' => 'required|date',
        ]);

        $filteredProducts = collect($validatedData['product_id'])
            ->zip($validatedData['quantity']) // Pair product_id with quantity
            ->filter(fn ($pair) => $pair[1] > 0); // Remove products with quantity 0

        if ($filteredProducts->isEmpty()) {
            return redirect()->back()->withErrors(['quantity' => 'Minimal satu produk harus memiliki jumlah lebih dari 0.']);
        }

        foreach ($filteredProducts as [$productId, $quantity]) {
            $product = Product::findOrFail($productId);

            $product->locations()->attach(
                $validatedData['location_id'],
                [
                    'user_id' => $validatedData['user_id'],
                    'quantity' => $quantity,
                    'date' => $validatedData['created_at'],
                ]
            );
        }

        return redirect()->route('product.input.form')->with('toast_success', 'Berhasil Menyimpan Data!');
    }
}
