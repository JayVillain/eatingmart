<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
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
        return response()->json(['user' => $user, 'token' => $token], 201);
    }
    public function login(Request $request)
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
        $token = $user->createToken('customer_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }
    public function adminLogin(Request $request)
    {
        $request->validate(['email' => 'required|string|email', 'password' => 'required|string']);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password) || $user->role !== 'admin') {
            throw ValidationException::withMessages(['email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.']]);
        }
        $token = $user->createToken('admin_token', ['admin'])->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }
}