<?php

namespace App\Repositories;

use App\Models\Departament;

class DepartamentsRepository extends BaseRepository
{
    public function __construct(Departament $modelo)
    {
        parent::__construct($modelo);
    }
    
}
