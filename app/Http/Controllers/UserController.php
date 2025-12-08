<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'profile_image' => 'nullable|image|max:2048',
            'role' => 'required|in:admin,staff',
        ]);

        // If creating an admin, ensure no other admin exists (respect single-admin rule)
        if ($request->role === 'admin' && User::where('role','admin')->exists()) {
            return back()->withErrors(['role' => 'An admin already exists. Only one admin allowed.'])->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images','public');
        }

        User::create($data);

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
            'profile_image' => 'nullable|image|max:2048',
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
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $request->file('profile_image')->store('profile_images','public');
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
