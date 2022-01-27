<?php

namespace App\Repository;

use App\Models\Doctor;

class DoctorRepository
{
    private Doctor $model;

    public function __construct(Doctor $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
