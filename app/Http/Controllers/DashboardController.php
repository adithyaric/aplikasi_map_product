<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        return view('dashboard.index', [
            'provinces' => Location::where('type', 'provinsi')->get(),
            'products' => Product::get(),
            'colors' => $colors,
        ]);
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
