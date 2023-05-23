<?php

namespace App\Repositories;

use App\Models\WithholdingTaxe;

class WithholdingTaxeRepository extends BaseRepository
{
    public function __construct(WithholdingTaxe $modelo)
    {
        parent::__construct($modelo);
    }
    
}
