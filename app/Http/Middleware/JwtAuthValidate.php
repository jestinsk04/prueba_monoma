<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class JwtAuthValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // Intenta obtener el usuario a partir del token JWT en el encabezado
            $user = JWTAuth::parseToken()->authenticate();
            // Agrega el usuario al request para que esté disponible en los controladores
            $request->merge(['user' => $user]);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Token expirado']
                ]
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Token inválido']
                ]
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Token ausente o inválido']
                ]
            ], 401);
        }

        return $next($request);
    }

}