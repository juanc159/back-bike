<?php

namespace App\Repositories;

use App\Models\TypeIdentification;

class TypeIdentificationRepository extends BaseRepository
{
    public function __construct(TypeIdentification $modelo)
    {
        parent::__construct($modelo);
    }
    
}
