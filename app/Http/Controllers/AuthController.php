<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return redirect()
                ->back()
                ->withErrors(['login' => 'Invalid email or password'])
                ->withInput(); // Retain old input data
        }

         // Use Auth facade to get the authenticated user
        $user = Auth::user();
        $userId = $user->id;

        // Add user_id, role, and name claims to token
        $token = JWTAuth::claims(['user_id' => $userId, 'role' => $user->role, 'name' => $user->name])->fromUser($user);

        session(['access_token' => $token]);

        return redirect('/dashboard');
    }

    public function registerPage()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect('/login');
    }

    public function logout()
    {
        session()->forget('access_token');
        return redirect('/login');
    }

    public function getAuthClaims(Request $request)
    {
        $authClaims = $request->get('auth_claims');
        return response()->json($authClaims);
    }
}
