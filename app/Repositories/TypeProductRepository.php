<?php

namespace App\Repositories;
 
use App\Models\TypeProduct;

class TypeProductRepository extends BaseRepository
{
    public function __construct(TypeProduct $modelo)
    {
        parent::__construct($modelo);
    }
    
}
