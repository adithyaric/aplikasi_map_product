<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Models\User;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

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
        $data = $this->locationService->getLocationProductMapping($type, $parentId);

        if (isset($data[0]['coordinates'])) {
            return view('map.index', ['data' => $data, 'lokasi' => $type]);
        }

        return response()->json($data);
    }

    public function getParents(Request $request)
    {
        $type = $request->get('type');
        $locations = Location::where('type', $type)->get(['id', 'name']);

        return response()->json($locations);
    }

    public function getChildLocations($type, $parentId)
    {
        $locations = Location::where('type', $type)
            ->where('parent_id', $parentId)
            ->get();

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
}
