<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required'
            ]
        ]);

        $credentials = $request->only(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->service->respondWithToken($token);
    }

    public function test()
    {
        return response()->json(['result' => 'hello']);
    }

    /**
     * Register the user
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->service->register($request->input());
        return response()->json(!isset($user) ? ['result' => 'could\'t create a new user '] :['result'  => ['user' => $user->attributesToArray()]]);
    }

    public function logout()
    {
        auth()->logout(true);
        return response()->json('logged out');
    }


}
