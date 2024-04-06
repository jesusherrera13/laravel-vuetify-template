<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request) {

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $response = [
            'user' => $user,
            // 'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $user = User::where('email', $fields['email'])->first();
        // $user->tokens()->delete();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }

    public function user(User $user) {
        
        return response($user, 200);
    }

    public function logout(Request $request) {

        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logged out'
        ], 201);
    }
}
