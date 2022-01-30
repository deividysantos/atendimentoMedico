<?php

namespace App\Repository;

use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientRepository implements IModelRepository
{
    private Patient $model;

    public function __construct(Patient $patient)
    {
        $this->model = $patient;
    }

    public function create(array $payload)
    {
        $data = $this->makePayloadDoctor($payload);

        return $this->model->create($data);
    }

    public function makePayloadDoctor(array $payload): array
    {
        return [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'document_id' => $payload['document_id'],
            'phoneNumber' => $payload['phoneNumber'],
            'password' => Hash::make($payload['password'])
        ];
    }
}
