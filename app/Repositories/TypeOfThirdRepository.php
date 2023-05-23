<?php

namespace App\Repositories;

use App\Models\TypeOfThird;

class TypeOfThirdRepository extends BaseRepository
{
    public function __construct(TypeOfThird $modelo)
    {
        parent::__construct($modelo);
    }
    
}
