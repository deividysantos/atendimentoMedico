<?php

namespace App\Repository;

class AuthRepository
{
    public function authenticate()
    {

    }

    public function getGuard(string $provider)
    {
        if($provider == 'doctor')
            return 'doctors';

        if($provider == 'patient')
            return 'patients';

        return false;
    }
}
