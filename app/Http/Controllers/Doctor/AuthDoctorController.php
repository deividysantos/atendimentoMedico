<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function auth;
use function response;

class AuthDoctorController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $token = auth()->attempt($credentials);

        if(!$token)
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logeed out']);
    }
}
