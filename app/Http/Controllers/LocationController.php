<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        return view('location.index', [
            'locations' => Location::get(),
        ]);
    }

    public function create()
    {
        return view('location.create');
    }

    public function store(LocationRequest $request)
    {
        $data = $request->validated();
        Location::create($data);

        return redirect(route('locations.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function edit(Location $location)
    {
        $parentType = match ($location->type) {
            'kabupaten' => 'provinsi',
            'kecamatan' => 'kabupaten',
            'desa' => 'kecamatan',
            'dusun' => 'desa',
            default => null,
        };

        $parentLocations = $parentType
            ? Location::where('type', $parentType)->get()
            : collect(); // Empty collection for 'provinsi'

        return view('location.edit', [
            'location' => $location,
            'parentLocations' => $parentLocations,
        ]);
    }

    public function update(LocationRequest $request, Location $location)
    {
        $data = $request->validated();
        $location->update($data);

        return redirect(route('locations.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect(route('locations.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }

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
            $productsData = $location->products->mapWithKeys(function ($product) use ($totalQuantity, $location) {
                // $quantity = $product->pivot->quantity;
                $quantity = $location->products->where('id', $product->id)->sum('pivot.quantity');
                $percentage = $totalQuantity > 0 ? round(($quantity / $totalQuantity) * 100, 2) : 0;

                // return [$product->name => $percentage . '%'];
                return [$product->name => $percentage];
            });

            return [
                'id' => $location->id,
                'name' => $location->name,
                'data' => $productsData,
                'coordinates' => json_decode($location->coordinates),
                'color' => $this->getColor($totalQuantity),
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
                'data' => $data,
                'lokasi' => $locations[0]->type,
            ]);
        } else {
            return response()->json($data);
        }
    }

    public function getParents(Request $request)
    {
        $type = $request->get('type');
        $locations = Location::where('type', $type)->get(['id', 'name']);

        return response()->json($locations);
    }

    private function getColor($totalQuantity)
    {
        // Define color thresholds
        $colors = [
            // 5   => "#ADD8E6", // Light Blue
            // 10  => "#0000FF", // Blue
            // 15  => "#00008B", // Dark Blue
            // 20  => "#000080", // More Darker Blue
            // 25  => "#000033", // Darkest Blue
            5 => 'blue', // Light Blue
            10 => 'orange', // Blue
            15 => 'red', // Dark Blue
            20 => 'green', // More Darker Blue
            25 => 'black', // Darkest Blue
        ];

        // Find the appropriate color based on the thresholds
        foreach ($colors as $threshold => $color) {
            if ($totalQuantity <= $threshold) {
                return $color;
            }
        }

        // Default color if above all thresholds
        return 'yellow'; // Blue
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
