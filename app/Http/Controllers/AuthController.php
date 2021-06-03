<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(RegisterRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->service->respondWithToken($token);
    }

    public function test()
    {
        if(($error = $this->service->authorizeJWT()) !== true){
            return $error;
        }
        return response()->json(['result' => 'hello']);
    }

    public function logout()
    {
        auth()->logout(true);
        return response()->json('logged out');
    }


}
