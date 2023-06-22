<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $levels = ['Owner', 'Administrasi', 'Finance'];

        return view('users.create', compact('levels'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        User::create($data);

        return redirect(route('users.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(User $user)
    {
        dd($user);
    }

    public function edit(User $user)
    {
        $levels = ['Owner', 'Administrasi', 'Finance'];

        return view('users.edit', compact('user', 'levels'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'same:confirm-password',
        ]);

        $data = $request->all();
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data = Arr::except($data, ['password']);
        }

        $user->update($data);

        return redirect(route('users.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect(route('users.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
