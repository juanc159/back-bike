<?php

namespace App\Repositories;

use App\Models\FiscalResponsability;

class FiscalResponsabilityRepository extends BaseRepository
{
    public function __construct(FiscalResponsability $modelo)
    {
        parent::__construct($modelo);
    }
    
}
