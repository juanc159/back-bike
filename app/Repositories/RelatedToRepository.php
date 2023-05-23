<?php

namespace App\Repositories;

use App\Models\RelatedTo;

class RelatedToRepository extends BaseRepository
{
    public function __construct(RelatedTo $modelo)
    {
        parent::__construct($modelo);
    }
    
}
