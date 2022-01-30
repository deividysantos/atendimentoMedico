<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterDoctorRequest;
use App\Repository\DoctorRepository;

class RegisterDoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function postRegisterDoctor(RegisterDoctorRequest $request)
    {
        $this->doctorRepository->create($request->all());

        $token = auth('doctors')->attempt(
            [
                'email' => $request['email'],
                'password' => $request['password']
            ]
        );

        return response()->json([
            'message' => 'success, the new doctor has been registered',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 201);
    }
}
