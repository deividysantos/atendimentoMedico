<?php

namespace App\Repository;

interface IModelRepository
{
    public function create(array $payload);

    public function makePayloadDoctor(array $payload):array;
}
