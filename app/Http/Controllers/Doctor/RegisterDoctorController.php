<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterDoctorRequest;
use App\Repository\DoctorRepository;
use Illuminate\Support\Facades\Hash;

class RegisterDoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }


    public function postRegisterDoctor(RegisterDoctorRequest $request)
    {
        $payload = $this->makePayloadDoctor($request->all());

        $doctorModel = $this->doctorRepository->create($payload);

        $token = auth()->attempt($this->getCredentials($request));

        return response()->json([
            'message' => 'success, the new doctor has been registered',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 201);
    }

    private function makePayloadDoctor($request): array
    {
        return [
            'name' => $request['name'],
            'email' => $request['email'],
            'documentMedical_id' => $request['documentMedical_id'],
            'password' => Hash::make($request['password'])
        ];
    }

    public function getCredentials(RegisterDoctorRequest $request)
    {
        return( [
            'email' => $request['email'],
            'password' => $request['password']
        ]);
    }


}
