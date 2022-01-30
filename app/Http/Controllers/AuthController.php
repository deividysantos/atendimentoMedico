<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repository\AuthRepository;

class AuthController extends Controller
{
    CONST PROVIDERS = ['doctor', 'patient'];

    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request, string $provider)
    {
        $guard = $this->authRepository->getGuard($provider);

        if(!$guard)
            return response()->json([
                'message' => 'Provider not found',
            ], 404);

        $credentials = $request->only('email', 'password');

        $token = auth($guard)->attempt($credentials);

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

    public function logout(string $provider)
    {

        if(!$this->authRepository->getGuard($provider))
            return response()->json([
                'message' => 'Provider not found',
            ], 404);

        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
