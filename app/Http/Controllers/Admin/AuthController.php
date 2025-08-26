<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // --- FUNGSI UNTUK PANEL ADMIN (WEB) ---

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function webLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            Auth::logout();
        }

        return back()->withErrors(['email' => 'Kredensial tidak valid.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // --- FUNGSI UNTUK APLIKASI PELANGGAN (API) ---

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        $token = $user->createToken('customer_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.'],
            ]);
        }
        
        // Cek peran untuk memastikan hanya pelanggan yang bisa login via API
        if ($user->role !== 'customer') {
             throw ValidationException::withMessages([
                'email' => ['Akses ditolak.'],
            ]);
        }

        $token = $user->createToken('customer_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}