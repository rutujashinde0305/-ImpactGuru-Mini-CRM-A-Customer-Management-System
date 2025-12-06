<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $users = User::orderBy('created_at','desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,staff',
        ]);

        // If creating an admin, ensure no other admin exists (respect single-admin rule)
        if ($request->role === 'admin' && User::where('role','admin')->exists()) {
            return back()->withErrors(['role' => 'An admin already exists. Only one admin allowed.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success','User created');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,staff',
        ]);

        if ($request->role === 'admin' && User::where('role','admin')->where('id','!=',$user->id)->exists()) {
            return back()->withErrors(['role' => 'An admin already exists. Only one admin allowed.'])->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success','User updated');
    }

    public function destroy(User $user)
    {
        // prevent deleting the last admin
        if ($user->role === 'admin') {
            return back()->withErrors(['user' => 'Cannot delete the admin user.']);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted');
    }
}
