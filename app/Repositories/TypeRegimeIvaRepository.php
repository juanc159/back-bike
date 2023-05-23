<?php

namespace App\Repositories;

use App\Models\TypeRegimeIva;

class TypeRegimeIvaRepository extends BaseRepository
{
    public function __construct(TypeRegimeIva $modelo)
    {
        parent::__construct($modelo);
    }
    
}
