<?php

namespace App\Repository;

interface IModelRepository
{
    public function create(array $payload):bool;

    public function makePayloadDoctor(array $payload):array;
}
