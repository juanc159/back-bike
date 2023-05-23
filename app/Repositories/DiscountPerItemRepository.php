<?php

namespace App\Repositories;

use App\Models\DiscountPerItem;

class DiscountPerItemRepository  extends BaseRepository
{
    public function __construct(DiscountPerItem $modelo)
    {
        parent::__construct($modelo);
    }
    
}
