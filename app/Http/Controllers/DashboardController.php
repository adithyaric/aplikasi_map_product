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
        // $data = $this->locationService->getLocationProductMapping($type, $parentId);
        $locations = Location::where('type', $type)
            ->when($parentId, function ($query) use ($parentId) {
                $query->where('parent_id', $parentId);
            })
            ->with(['products', 'children.children.children.children.products']) // Load all child levels
            ->get();

        $data = $locations->map(function ($location) {
            // Get all products from this location and its children recursively
            switch ($location->type) {
                case 'dusun':
                    $allProducts = $location->products;
                    break;

                case 'desa':
                    $dusunLocations = $location->children; // Get dusun locations
                    $allProducts = $dusunLocations->flatMap->products;
                    break;

                case 'kecamatan':
                    $desaLocations = $location->children; // Get desa locations
                    $dusunLocations = $desaLocations->flatMap->children; // Get dusun under desa
                    $allProducts = $dusunLocations->flatMap->products;
                    break;

                case 'kabupaten':
                    $kecamatanLocations = $location->children; // Get kecamatan locations
                    $desaLocations = $kecamatanLocations->flatMap->children; // Get desa under kecamatan
                    $dusunLocations = $desaLocations->flatMap->children; // Get dusun under desa
                    $allProducts = $dusunLocations->flatMap->products;
                    break;

                case 'provinsi':
                    $kabupatenLocations = $location->children; // Get kabupaten locations
                    $kecamatanLocations = $kabupatenLocations->flatMap->children; // Get kecamatan under kabupaten
                    $desaLocations = $kecamatanLocations->flatMap->children; // Get desa under kecamatan
                    $dusunLocations = $desaLocations->flatMap->children; // Get dusun under desa
                    $allProducts = $dusunLocations->flatMap->products;
                    break;

                default:
                    $allProducts = collect(); // Empty collection for unknown types
            }

            $totalQuantity = $allProducts->sum('pivot.quantity');

            // Calculate percentage for each product
            $productsData = $allProducts->groupBy('id')->mapWithKeys(function ($group, $productId) use ($totalQuantity) {
                $productName = $group->first()->name;
                $quantity = $group->sum('pivot.quantity');
                $percentage = $totalQuantity > 0 ? round(($quantity / $totalQuantity) * 100, 2) : 0;

                return [$productName => $percentage.'%'.' - '.$quantity.' item'];
            });

            return [
                'id' => $location->id,
                'name' => $location->name,
                'data' => $productsData,
                'coordinates' => json_decode($location->coordinates),
                'color' => $this->getColor($totalQuantity),
                'nextRoute' => route('dashboard', ['type' => $this->getnextRoute($location->type), 'parentId' => $location->id]),
                'children' => $location->children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'type' => $child->type,
                    ];
                }),
            ];
        });

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

    private function getColor($totalQuantity)
    {
        // Define color thresholds
        $colors = [
            0 => '#ff0000',
            100 => '#7ad9ff',
            500 => '#1696c9',
        ];

        // Find the appropriate color based on the thresholds
        foreach ($colors as $threshold => $color) {
            if ($totalQuantity <= $threshold) {
                return $color;
            }
        }

        // Default color if above all thresholds
        return '#035e82'; // Blue
    }

    private function getnextRoute($type)
    {
        $next = [
            'provinsi' => 'kabupaten',
            'kabupaten' => 'kecamatan',
            'kecamatan' => 'desa',
            'desa' => 'dusun',
            'dusun' => ' ',
        ];

        return $next[$type] ?? null;
    }
}
