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

        $entity = $this->doctorRepository->create($payload);

        return response()->json([
            'message' => 'success, the new doctor has been registered',
            'entity' => $entity
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


}
