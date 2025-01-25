<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getLocationProductMapping($type, $parentId = null)
    {
        $locations = Location::where('type', $type)
            ->when($parentId, function ($query) use ($parentId) {
                $query->where('parent_id', $parentId);
            })
            ->with(['products', 'children'])
            ->get();

        $data = $locations->map(function ($location) {
            // Total quantity of all products in this location
            $totalQuantity = $location->products->sum('pivot.quantity');

            // Calculate percentage for each product
            $productsData = $location->products->mapWithKeys(function ($product) use ($totalQuantity) {
                $quantity = $product->pivot->quantity;
                $percentage = $totalQuantity > 0 ? round(($quantity / $totalQuantity) * 100, 2) : 0;

                // return [$product->name => $percentage . '%'];
                return [$product->name => $percentage];
            });

            return [
                'id' => $location->id,
                'name' => $location->name,
                'data' => $productsData,
                'coordinates' => json_decode($location->coordinates),
                'color' => $this->getColor($location->type),
                'nextRoute' => route('locations', ['type' => $this->getnextRoute($location->type), 'parentId' => $location->id]),
                'children' => $location->children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'type' => $child->type,
                    ];
                }),
            ];
        });

        if (isset($data[0]['coordinates'])) {
            return view('map.index', [
                'data' => $data
            ]);
        }else{
            return response()->json($data);
        }
    }

    private function getColor($type)
    {
        $colors = [
            'provinsi' => 'blue',
            'kabupaten' => 'green',
            'kecamatan' => 'red',
            'desa' => 'yellow',
            'dusun' => 'purple',
        ];

        return $colors[$type] ?? 'gray';
    }

    private function getnextRoute($type)
    {
        $next = [
            'provinsi' => 'kabupaten',
            'kabupaten' => 'kecamatan',
            'kecamatan' => 'desa',
            'desa' => 'dusun',
        ];

        return $next[$type] ?? null;
    }
}
