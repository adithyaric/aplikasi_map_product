<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Product;
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
            'bahanbakus' => BahanBaku::get(),
            'categories' => Category::get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['harga'] = str_replace(',', '', $data['harga']);
        $product = Product::create([
            'name' => $data['name'],
            'harga' => $data['harga'],
            'category_id' => $data['category_id'],
        ]);

        $product->bahanbaku()->attach($data['bahanbaku']);

        return redirect(route('product.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Product $product)
    {
        dd($product);
    }

    public function edit(Product $product)
    {
        return view('product.edit', [
            'bahanbakus' => BahanBaku::get(),
            'categories' => Category::get(),
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $data['harga'] = str_replace(',', '', $data['harga']);
        $product->update([
            'name' => $data['name'],
            'harga' => $data['harga'],
            'category_id' => $data['category_id'],
        ]);

        $product->bahanbaku()->detach();
        $product->bahanbaku()->sync($data['bahanbaku']);

        return redirect(route('product.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect(route('product.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
