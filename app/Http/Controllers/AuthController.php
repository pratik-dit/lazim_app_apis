<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $role = Role::where('name', 'user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        return response()->json([
            'success' => true, 
            'status' => 200, 
            'message' => 'User registered successfully', 
            'data' => [
                'user' => new UserResource($user),
            ]
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'The provided credentials are incorrect. Please try again',
                'data' => [],
            ], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Logged in successfully',
            'data' => [
              'token' => $token,
              'user' => new UserResource($user),
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Logged out successfully',
            'data' => [],
        ]);
    }
}

