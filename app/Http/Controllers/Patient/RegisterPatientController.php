<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPatientRequest;
use App\Repository\PatientRepository;

class RegisterPatientController extends Controller
{
    private PatientRepository $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function postRegisterPatient(RegisterPatientRequest $request)
    {
        $this->patientRepository->create($request->all());

        $token = auth('patients')->attempt(
            [
            'email' => $request['email'],
            'password' => $request['password']
            ]
        );

        return response()->json([
            'message' => 'Success, the new patient has been registered',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 201);
    }
}
