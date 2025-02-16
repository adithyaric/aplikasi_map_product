<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use App\Models\RequestInput;
use App\Models\User;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index()
    {
        $products = Product::get();

        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create', []);
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
        $users = $authUser->role === 'admin' ? User::where('role', 'sales')->get() : User::where('id', $authUser->id)->get();
        $products = Product::get();

        if ($authUser->role === 'sales') {
            return view('sales.inputpenyebaran', compact('users', 'products'));
        } else {
            return view('inputpenyebaran', compact('users', 'products'));
        }
    }

    public function inputProductQuantity(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id', // This is dusun_id
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:0',
            'created_at' => 'required|date',
        ]);

        // Fetch the dusun location and traverse up the hierarchy
        $dusun = Location::findOrFail($validatedData['location_id']);
        $desa = $dusun->parent;
        $kecamatan = $desa?->parent;
        $kabupaten = $kecamatan?->parent;
        $provinsi = $kabupaten?->parent;

        $filteredProducts = collect($validatedData['product_id'])
            ->zip($validatedData['quantity'])
            ->filter(fn ($pair) => $pair[1] > 0);

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
                    'location_dusun_id' => $validatedData['location_id'],
                    'location_desa_id' => $desa?->id,
                    'location_kecamatan_id' => $kecamatan?->id,
                    'location_kabupaten_id' => $kabupaten?->id,
                    'location_provinsi_id' => $provinsi?->id,
                ]
            );
        }

        return redirect()->route('product.input.form')->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function inputProductQuantityHistory()
    {
        $query = DB::table('location_product')
            ->join('users', 'location_product.user_id', '=', 'users.id')
            ->join('locations', 'location_product.location_id', '=', 'locations.id')
            ->join('products', 'location_product.product_id', '=', 'products.id')
            ->select(
                'location_product.*',
                'users.name as user_name',
                'locations.name as location_name',
                'products.name as product_name'
            );

        if (auth()->user()->role === 'sales') {
            $query->where('location_product.user_id', auth()->id());
        }

        $locationProducts = $query->orderBy('location_product.date', 'desc')
            ->get();

        if (auth()->user()->role === 'admin') {
            $requestInputs = RequestInput::with(['user', 'location'])->latest()->get();

            return view('inputpenyebaranhistory', [
                'requestInputs' => $requestInputs,
                'locationProducts' => $locationProducts,
            ]);
        }

        return view('sales.inputpenyebaranhistory', compact('locationProducts'));
    }

    public function editProductQuantity($id)
    {
        $locationProduct = DB::table('location_product')
            ->where('id', $id)
            ->first();

        if (! $locationProduct) {
            return redirect()->back()->withErrors(['msg' => 'Data tidak ditemukan.']);
        }

        return view('inputpenyebaranedit', compact('locationProduct'));
    }

    public function updateProductQuantity(Request $request, $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:0',
            'date' => 'required|date',
        ]);

        DB::table('location_product')
            ->where('id', $id)
            ->update([
                'quantity' => $validatedData['quantity'],
                'date' => $validatedData['date'],
                'updated_at' => now(),
            ]);

        return redirect()->route('product.input.history')->with('toast_success', 'Data berhasil diperbarui!');
    }

    //fetch data
    public function getChartData(Request $request)
    {
        return $this->locationService->getChartData($request);
    }

    public function getLeaderboard(Request $request)
    {
        $leaderboard = $this->locationService->getLeaderboard($request);
        $products = Product::select('id', 'name')->whereNull('deleted_at')->get();

        return response()->json([
            'leaderboard' => $leaderboard,
            'products' => $products,
        ]);
    }

    public function getProductLeaderboardData(Request $request)
    {
        $productLeaderboard = $this->locationService->getProductLeaderboard($request);
        $products = Product::select('id', 'name')->whereNull('deleted_at')->get();

        return response()->json([
            'productLeaderboard' => $productLeaderboard,
            'products' => $products,
        ]);
    }
}
