<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController
{
    public function login(LoginRequest $request){
        // $validated = $request->validate([]);
        $validated = $request->validated();
        $user = User::where('email',$validated['email'])->first(); 
        if(! $user || ! Hash::check($validated['password'],$user->password)){
           return response()->json([
            'message'=>'The provided credentials are incorrect.'
           ],401);
        }
        $token = $user->createToken('laptop')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function register(RegisterRequest $request){
        // $validated = $request->validate([]); 
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'data'=>new UserResource($user),
            'token'=>$token,
            'message'=>'Registration successful'
        ]);
    }

    public function me(Request $request)
    {
    return response()->json([
        'message' => 'Authenticated user fetched successfully',
        'user' => new UserResource($request->user()),
    ]);
    }
}
