<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->token =  $user->createToken('auth_token')->plainTextToken;

        return Response()->withSuccess(
            message: "Register  successfully",
            data: UserResource::make($user)->resolve()
        );
    }

    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (!$user || !Hash::check($request->password, $user->password)) {

            return Response()->withErrors(message: 'email or password incorrect', code: 401);
        }

        $user->token =  $user->createToken('auth_token')->plainTextToken;

        return Response()->withSuccess(
            message: "login successfully",
            data: UserResource::make($user)->resolve()
        );
    }


    public function logout()
    {
        auth('sanctum')->user()->currentAccessToken()->delete();
        return Response()->withSuccess(message: "logout successfully");
    }
}
