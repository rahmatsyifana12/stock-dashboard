<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $this->extractToken($request);

        if (!$token || !$this->validateToken($token)) {
            return redirect('/login');
        }

        $payload = JWTAuth::getPayload();
        $authClaims = array(
            'user_id' => $payload->get('user_id'),
            'role' => $payload->get('role'),
            'name' => $payload->get('name'),
        );

        $request->merge(['auth_claims' => $authClaims]);

        return $next($request);
    }

    /**
     * Extract the JWT token from session or request.
     */
    private function extractToken(Request $request): ?string
    {
        $token = session('access_token');

        if ($token && str_contains($token, 'Bearer ')) {
            return Str::after($token, 'Bearer ');
        }

        return $token;
    }

    /**
     * Validate the JWT token.
     */
    private function validateToken(string $token): bool
    {
        try {
            JWTAuth::setToken($token);

            return JWTAuth::check();
        } catch (TokenExpiredException | TokenInvalidException | JWTException $e) {
            Log::error('JWT validation error: ' . $e->getMessage());
            return false;
        }
    }
}
