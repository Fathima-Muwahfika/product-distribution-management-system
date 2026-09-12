<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('dashboard')
                : redirect()->route('salesrep.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {

    // Check if user is active
    if (Auth::user()->status === 'Inactive') {
        Auth::logout();
        return back()->withErrors([
            'email' => 'Your account has been deactivated. Please contact admin.',
        ]);
    }

    // Check if selected role matches actual role
    if ($request->role !== Auth::user()->role) {
        Auth::logout();
        return back()->withErrors([
            'email' => 'Selected role does not match your account. Please select the correct role.',
        ]);
    }

    $request->session()->regenerate();

    // Log activity
    ActivityLog::create([
        'user_id'     => Auth::id(),
        'action'      => 'Login',
        'module'      => 'Auth',
        'description' => Auth::user()->name . ' logged in as ' . Auth::user()->role,
        'ip_address'  => $request->ip(),
    ]);

    return Auth::user()->isAdmin()
        ? redirect()->route('dashboard')
        : redirect()->route('salesrep.dashboard');
}

        return back()->withErrors([
            'email' => 'Invalid email or password. Please try again.',
        ]);
    }

    public function logout(Request $request)
    {
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Logout',
            'module'      => 'Auth',
            'description' => Auth::user()->name . ' logged out.',
            'ip_address'  => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}