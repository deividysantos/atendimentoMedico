<?php

namespace App\Repository;

use App\Models\Attendance;

class AttendanceRepository implements IModelRepository
{
    private Attendance $model;

    public function __construct(Attendance $attendance)
    {
        $this->model = $attendance;
    }

    public function create(array $payload)
    {
        $data = $this->makePayloadDoctor($payload);

        return $this->model->create($data);
    }

    public function makePayloadDoctor(array $payload): array
    {
        return [
            'doctor_id' => auth()->id(),
            'patient_id' => $payload['patient_id'],
            'entryDate' => $payload['entryDate'],
            'description' => $payload['description']
        ];
    }
}
