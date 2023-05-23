<?php

namespace App\Repositories;

use App\Models\BasicDataType;

class BasicDataTypeRepository extends BaseRepository
{
    public function __construct(BasicDataType $modelo)
    {
        parent::__construct($modelo);
    }
    
}
