<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use App\Services\LocationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index(Request $request, $type = 'provinsi', $parentId = null)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('product.input.form');
        }
        $data = $this->locationService->getLocationProductMapping($type, $parentId);

        // $leaderboard = $this->locationService->getLeaderboard();
        // $productLeaderboard = $this->locationService->getProductLeaderboard();
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];
        $products = Product::select('id', 'name')->get();

        return view('dashboard.index', [
            'provinces' => Location::where('type', 'provinsi')->get(),
            'kabupatens' => Location::where('type', 'kabupaten')->where('parent_id', $request->location_provinsi_id)->get(),
            'kecamatans' => Location::where('type', 'kecamatan')->where('parent_id', $request->location_kabupaten_id)->get(),
            'desas' => Location::where('type', 'desa')->where('parent_id', $request->location_kecamatan_id)->get(),
            'dusuns' => Location::where('type', 'dusun')->where('parent_id', $request->location_desa_id)->get(),
            'products' => $products,
            'colors' => $colors,
            'data' => $data,
            'lokasi' => $type,
            // 'leaderboard' => $leaderboard,
            // 'productLeaderboard' => $productLeaderboard,
        ]);
    }

    public function statistic(Request $request)
    {
        return view('dashboard.statistic', [
            'provinces' => Location::where('type', 'provinsi')->get(),
            'kabupatens' => Location::where('type', 'kabupaten')->where('parent_id', $request->location_provinsi_id)->get(),
            'kecamatans' => Location::where('type', 'kecamatan')->where('parent_id', $request->location_kabupaten_id)->get(),
            'desas' => Location::where('type', 'desa')->where('parent_id', $request->location_kecamatan_id)->get(),
            'dusuns' => Location::where('type', 'dusun')->where('parent_id', $request->location_desa_id)->get(),
        ]);
    }
}
