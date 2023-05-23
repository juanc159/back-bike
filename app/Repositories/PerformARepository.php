<?php

namespace App\Repositories;

use App\Models\PerformA;

class PerformARepository extends BaseRepository
{
    public function __construct(PerformA $modelo)
    {
        parent::__construct($modelo);
    }
    
}
