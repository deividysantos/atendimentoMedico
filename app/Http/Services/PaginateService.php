<?php

namespace App\Http\Services;

class PaginateService
{

    public function paginateAllAttendancesToDoctor(int $paginate): array
    {
        $skip = function ($paginate)
        {
            if($paginate == 1)
                return 0;

            return (($paginate - 1) * 10) + 1;
        };

        $take = 10;

        return ['skip' => $skip($paginate), 'take' => $take];
    }
}
