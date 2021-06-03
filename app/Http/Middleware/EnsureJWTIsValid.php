<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;

class EnsureJWTIsValid
{
    // handles dependency injection
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(($error = $this->authService->authorizeJWT()) !== true){
            return $error;
        }
        return $next($request);
    }
}
