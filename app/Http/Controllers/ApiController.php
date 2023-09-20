<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class ApiController extends Controller
{
    //
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Password or User incorrect for: ' . $credentials['username']]
                ]
            ], 401);
        }

        // actualizar inicio de sesion
        User::where('username', $credentials['username'])->update(['last_login' => now()]);

        return response()->json([
            'meta' => [
                'success' => true,
                'errors' => []
            ],
            'data' => [
                'token' => $token,
                'minutes_to_expire' => auth()->factory()->getTTL()
            ]
        ], 200);


    }



}