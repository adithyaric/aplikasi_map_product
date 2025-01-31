<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($type = 'provinsi', $parentId = null)
    {
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

        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        return view('dashboard.index', [
            'provinces' => Location::where('type', 'provinsi')->get(),
            'products' => Product::get(),
            'colors' => $colors,
            'data' => $data,
            'lokasi' => $locations[0]->type,
        ]);
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

    public function statistic()
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        return view('dashboard.statistic', [
            'provinces' => Location::where('type', 'provinsi')->get(),
            'products' => Product::get(),
            'colors' => $colors,
        ]);
    }

    public function getChartData(Request $request)
    {
        $type = $request->type;
        $id = $request->id;

        // Define a set of colors
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        // Fetch the selected location and its children recursively
        $locations = Location::where('type', $type)
            ->when($id, function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->with(['products', 'children.children.children.children.products'])
            ->get();

        $data = $locations->map(function ($location) use ($colors) {
            $allProducts = $this->getAllProducts($location);
            // $totalQuantity = $allProducts->sum('pivot.quantity');

            // Group products by name and sum their quantities
            $productsData = $allProducts->groupBy('name')->map(function ($group) {
                return $group->sum('pivot.quantity');
            });

            // Get unique product names
            $productNames = $productsData->keys()->toArray();
            // $productCount = count($productNames);

            // Assign colors based on the number of products
            $productColors = [];
            foreach ($productNames as $index => $name) {
                $productColors[$name] = $colors[$index % count($colors)];
            }

            return [
                'name' => $location->name,
                'data' => $productsData,
                'colors' => $productColors, // Assign colors to each product
            ];
        });

        return response()->json($data);
    }

    // Helper function to get all products recursively
    private function getAllProducts($location)
    {
        $allProducts = collect();

        switch ($location->type) {
            case 'dusun':
                $allProducts = $location->products;
                break;

            case 'desa':
                $allProducts = $location->children->flatMap->products;
                break;

            case 'kecamatan':
                $allProducts = $location->children->flatMap(function ($child) {
                    return $child->children->flatMap->products;
                });
                break;

            case 'kabupaten':
                $allProducts = $location->children->flatMap(function ($child) {
                    return $child->children->flatMap(function ($grandChild) {
                        return $grandChild->children->flatMap->products;
                    });
                });
                break;

            case 'provinsi':
                $allProducts = $location->children->flatMap(function ($child) {
                    return $child->children->flatMap(function ($grandChild) {
                        return $grandChild->children->flatMap(function ($greatGrandChild) {
                            return $greatGrandChild->children->flatMap->products;
                        });
                    });
                });
                break;
        }

        return $allProducts;
    }

    public function getChildLocations($type, $parentId)
    {
        $locations = Location::where('type', $type)
            ->where('parent_id', $parentId)
            ->get();

        return response()->json($locations);
    }
}
