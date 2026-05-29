<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
            {
                $validated = $request->validate([

                    'name' => 'required|string|max:255',

                    'email' => 'required|email|unique:users,email',

                    'password' => 'required|min:8'

                ]);

                $user = User::create([

                    'name' => $validated['name'],

                    'email' => $validated['email'],

                    'password' => Hash::make($validated['password'])

                ]);

                Auth::login($user);

                return response()->json([

                    'message' => 'Register berhasil',

                    'user' => $user

                ]);
            }
       public function login(Request $request)
            {
                if (!Auth::attempt($request->only('email', 'password'))) {
                    return response()->json(['message' => 'Login gagal'], 401);
                }

                $request->session()->regenerate();

                return response()->json([
                    'auth_check' => Auth::check(),
                    'user' => Auth::user(),
                    'session_id' => session()->getId(),
                    'session_data' => session()->all(),
                ]);
            }            public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json(['message' => 'Logout']);
        }
       
}