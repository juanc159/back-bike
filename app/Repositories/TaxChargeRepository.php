<?php

namespace App\Repositories;

use App\Models\TaxCharge;

class TaxChargeRepository extends BaseRepository
{
    public function __construct(TaxCharge $modelo)
    {
        parent::__construct($modelo);
    }
    
}
