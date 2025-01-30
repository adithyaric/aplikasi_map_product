<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'provinces' => Location::where('type', 'provinsi')->get(),
        ]);
    }

    public function getChartData(Request $request)
    {
        $parentId = $request->id;
        $locations = Location::where('type', $request->type)
            ->when($parentId, function ($query) use ($parentId) {
                // $query->where('parent_id', $parentId);
                $query->where('id', $parentId);
            })
            ->with(['products', 'children.children.children.children.products'])
            ->get();
        $data = $locations->map(function ($location) {
            // Get all products from this location and its children recursively
            switch ($location->type) {
                case 'dusun':
                    $allProducts = $location->products;
                    break;

                case 'desa':
                    $dusunLocations = $location->children;
                    $allProducts = $dusunLocations->flatMap->products;
                    break;

                case 'kecamatan':
                    $desaLocations = $location->children;
                    $dusunLocations = $desaLocations->flatMap->children;
                    $allProducts = $dusunLocations->flatMap->products;
                    break;

                case 'kabupaten':
                    $kecamatanLocations = $location->children;
                    $desaLocations = $kecamatanLocations->flatMap->children;
                    $dusunLocations = $desaLocations->flatMap->children;
                    $allProducts = $dusunLocations->flatMap->products;
                    break;

                case 'provinsi':
                    $kabupatenLocations = $location->children;
                    $kecamatanLocations = $kabupatenLocations->flatMap->children;
                    $desaLocations = $kecamatanLocations->flatMap->children;
                    $dusunLocations = $desaLocations->flatMap->children;
                    $allProducts = $dusunLocations->flatMap->products;
                    break;

                default:
                    $allProducts = collect();
            }

            // $totalQuantity = $allProducts->sum('pivot.quantity');

            // Group products by name and sum their quantities
            $productsData = $allProducts->groupBy('name')->map(function ($group) {
                return $group->sum('pivot.quantity');
            });

            return [
                'name' => $location->name,
                'data' => $productsData,
            ];
        });

        // dd($data->toArray(), $locations->toArray());
        return response()->json($data);
    }

    public function getChildLocations($type, $parentId)
    {
        $locations = Location::where('type', $type)
            ->where('parent_id', $parentId)
            ->get();

        return response()->json($locations);
    }
}
