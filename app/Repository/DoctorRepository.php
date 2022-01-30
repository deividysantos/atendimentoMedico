<?php

namespace App\Repository;

use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorRepository implements IModelRepository
{
    private Doctor $model;

    public function __construct(Doctor $model)
    {
        $this->model = $model;
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
            'documentMedical_id' => $payload['documentMedical_id'],
            'password' => Hash::make($payload['password'])
        ];
    }
}
