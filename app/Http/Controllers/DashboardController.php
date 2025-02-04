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

    public function index($type = 'provinsi', $parentId = null)
    {
        $data = $this->locationService->getLocationProductMapping($type, $parentId);
        $leaderboard = $this->locationService->getLeaderboard();
        $productLeaderboard = $this->locationService->getProductLeaderboard();
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];
        $products = Product::select('id', 'name')->get();

        return view('dashboard.index', [
            'provinces' => Location::where('type', 'provinsi')->get(),
            'products' => $products,
            'colors' => $colors,
            'data' => $data,
            'lokasi' => $type,
            'leaderboard' => $leaderboard,
            'productLeaderboard' => $productLeaderboard,
        ]);
    }

    public function statistic(Request $request)
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        return view('dashboard.statistic', [
            'provinces' => Location::where('type', 'provinsi')->get(),
            // 'products' => Product::get(),
            'colors' => $colors,
        ]);
    }

    public function getChartData(Request $request)
    {
        return $this->locationService->getChartData($request->type, $request->id);
    }

    public function getChildLocations($type, $parentId)
    {
        $locations = Location::where('type', $type)
            ->where('parent_id', $parentId)
            ->get();

        return response()->json($locations);
    }
}
