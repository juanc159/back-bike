<?php

namespace App\Repositories;

use App\Models\TypeChargeAndDiscount;

class TypeChargeAndDiscountRepository extends BaseRepository
{
    public function __construct(TypeChargeAndDiscount $modelo)
    {
        parent::__construct($modelo);
    }
    
}
