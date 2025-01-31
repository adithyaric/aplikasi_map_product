<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Models\User;
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

    public function getLocationProductMapping($type = 'provinsi', $parentId = null)
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

    public function getDesa($user_id)
    {
        $user = User::findOrFail($user_id);

        // Get desa locations linked to this user
        $desaLocations = $user->locations()->where('type', 'desa')->get();

        return response()->json($desaLocations);
    }

    public function getDusun($desa_id)
    {
        // Get dusun locations under selected desa
        $dusunLocations = Location::where('parent_id', $desa_id)->where('type', 'dusun')->get();

        return response()->json($dusunLocations);
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
