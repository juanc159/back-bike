<?php

namespace App\Repositories;

use App\Models\ValidityInMonth;

class ValidityInMonthRepository extends BaseRepository
{
    public function __construct(ValidityInMonth $modelo)
    {
        parent::__construct($modelo);
    }
    
}
