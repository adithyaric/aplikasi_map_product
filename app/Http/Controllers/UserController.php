<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $levels = ['admin', 'sales'];
        $kecamatans = Location::where('type', 'kecamatan')->get();

        return view('users.create', compact('levels', 'kecamatans'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        // Get all desas under selected kecamatans
        $desas = Location::where('type', 'desa')
            ->whereIn('parent_id', $request->kecamatan_id) // Find desas where parent_id matches selected kecamatan
            ->pluck('id');

        // Attach desas to user
        $user->locations()->attach($desas);

        return redirect(route('users.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(User $user)
    {
        dd($user);
    }

    public function edit(User $user)
    {
        $levels = ['admin', 'sales'];
        $kecamatans = Location::where('type', 'kecamatan')->get();

        // Find kecamatan IDs from user's associated desas
        $selectedKecamatan = Location::where('type', 'desa')
            ->whereIn('id', $user->locations()->pluck('locations.id'))
            ->pluck('parent_id')
            ->unique()->toArray();

        return view('users.edit', compact('user', 'levels', 'kecamatans', 'selectedKecamatan'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|nullable|same:confirm-password',
        ]);

        $data = $request->except(['password', 'kecamatan_id']); // Exclude password & kecamatan from mass update
        if (! empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Get all desas under selected kecamatans
        $desas = Location::where('type', 'desa')
            ->whereIn('parent_id', $request->kecamatan_id)
            ->pluck('id');

        // Sync desa locations
        $user->locations()->sync($desas);

        return redirect(route('users.index'))->with('toast_success', 'Berhasil Memperbarui Data!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect(route('users.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
