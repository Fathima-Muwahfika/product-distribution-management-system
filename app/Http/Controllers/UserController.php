<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'salesrep')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required',
            'area'     => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'area'     => $request->area,
            'role'     => 'salesrep',
            'status'   => 'Active',
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Created',
            'module'      => 'Sales Rep',
            'description' => 'New sales rep added: ' . $request->name,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Sales Rep added successfully!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required',
            'area'  => 'required',
        ]);

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'area'   => $request->area,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Updated',
            'module'      => 'Sales Rep',
            'description' => 'Sales rep updated: ' . $user->name,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Sales Rep updated successfully!');
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Deleted',
            'module'      => 'Sales Rep',
            'description' => 'Sales rep deleted: ' . $name,
            'ip_address'  => request()->ip(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Sales Rep deleted successfully!');
    }

    public function show(User $user)
    {
        $orders = $user->orders()->with('shop')->latest()->take(10)->get();
        return view('users.show', compact('user', 'orders'));
    }
}