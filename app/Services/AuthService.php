<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function authorizeJWT()
    {
        try {

            if (!JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {

            return response()->json(['result' =>'token_expired']);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['result' =>'token_invalid']);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['result' =>'token_absent']);
        }
        return true;
    }

    /**
     * @param $data
     * @return User|null
     */
    public function register($data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email']
        ]);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
