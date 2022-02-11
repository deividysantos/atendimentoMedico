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

    public function logoutDoctor(): \Illuminate\Http\JsonResponse
    {
        return $this->logout('doctors');
    }

    public function logoutPatient(): \Illuminate\Http\JsonResponse
    {
        return $this->logout('patients');
    }

    public function logout(string $provider): \Illuminate\Http\JsonResponse
    {

        $userProvider = auth($provider)->check();

        if($userProvider){
            auth($provider)->logout();
            return response()->json(['message' => 'Successfully logged out']);
        }

        return response()->json(['message' => "User not logged in!"], 401);
    }
}
