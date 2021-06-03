<?php


namespace App\Services;


use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function authorizeJWT()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
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
