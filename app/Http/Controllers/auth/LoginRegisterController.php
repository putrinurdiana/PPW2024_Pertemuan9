<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRegisterController extends Controller
{
    // Constructor to apply middleware
    public function __construct()
    {
        // Apply guest middleware to all methods except logout and dashboard
        $this->middleware('guest')->except(['logout', 'dashboard']);

    }

    // Show the registration form
    public function register()
    {
        return view('auth.register');
    }

    // Handle registration form submission
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            // Hash the password for security
            'password' => Hash::make($request->password)
        ]);

        // Authenticate the user
        Auth::attempt($request->only('email', 'password'));
        $request->session()->regenerate();

        return redirect()->route('buku.index')
                         ->withSuccess('You have successfully registered and logged in.');
    }

    // Show the login form
    public function login()
    {
        return view('auth.login');
    }
    

    // Handle login form submission
    public function authenticate(Request $request)
    {
        // Validate the login credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('buku.index')
                             ->withSuccess('You have successfully logged in!');
        }

        // Return with errors if authentication fails
        return back()->withErrors([
            'email' => 'Your provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show the dashboard
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }

        return redirect()->route('login')
                         ->withErrors(['email' => 'Please login to access the dashboard.'])
                         ->onlyInput('email');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                         ->withSuccess('You have logged out successfully!');
    }
}
