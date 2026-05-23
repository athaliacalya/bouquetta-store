<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, fn($q) =>
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%")
        )
        ->when($request->role, fn($q) => $q->where('role', $request->role))
        ->latest()
        ->paginate(15)
        ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:500',
            'role'     => 'required|in:admin,customer',
            'password' => ['required', Password::min(6)],
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User '{$request->name}' berhasil ditambahkan!");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role'    => 'required|in:admin,customer',
        ]);

        $data = $request->only('name', 'email', 'phone', 'address', 'role');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->filled('password')) {
            $request->validate(['password' => Password::min(6)]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', "User '{$user->name}' berhasil diperbarui!");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }
        $name = $user->name;
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', "User '{$name}' berhasil dihapus!");
    }
}