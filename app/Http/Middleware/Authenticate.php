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

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = session('access_token');
            // Set the token
            JWTAuth::setToken($token);
            
            // Check if the token is valid
            if (!JWTAuth::check()) {
                return redirect('/login');
            }
    
            return $next($request);
    
        } catch (TokenExpiredException $e) {
            return redirect('/login');
        } catch (TokenInvalidException $e) {
            return redirect('/login');
        } catch (JWTException $e) {
            return redirect('/login');
        }
    }
}
