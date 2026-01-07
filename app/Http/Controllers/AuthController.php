<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
{
    $request->validate([
        'id' => 'required|string',
        'password' => 'required|string',
    ]);

    $loginId = trim($request->id);
    $password = $request->password;
    
    // Find user by userID
    $user = User::where('userID', $loginId)->first();
    
    if (!$user) {
        return back()->with('error', 'No account found with this ID.')->withInput($request->only('id'));
    }

    // Check password
    if (!Hash::check($password, $user->password)) {
        return back()->with('error', 'Incorrect password.')->withInput($request->only('id'));
    }

    // Login the user
    Auth::login($user, $request->filled('remember'));
    $request->session()->regenerate();
    
    Log::info('User logged in', ['userID' => $user->userID, 'name' => $user->name]);
    
    // Redirect based on role
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
    } elseif ($user->role === 'therapist') {
        return redirect()->route('therapist.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
    }
    
    // Fallback if role doesn't match expected roles
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login')->with('error', 'Invalid user role.');
}

    /**
     * Show register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phoneNumber' => 'nullable|string|max:20',
            'role' => 'required|in:therapist,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phoneNumber' => $request->phoneNumber,
        ]);

        Log::info('User registered', ['userID' => $user->userID, 'email' => $user->email]);

        // Redirect to login with success message showing the new userID
        return redirect()->route('login')->with('success', 'Registration successful! Your ID is: ' . $user->userID . '. Please login with your ID and password.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';
        $userId = Auth::id();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        Log::info('User logged out', ['userID' => $userId]);
        
        return redirect()->route('login')->with('success', 'You have been logged out successfully. See you again!');
    }
}