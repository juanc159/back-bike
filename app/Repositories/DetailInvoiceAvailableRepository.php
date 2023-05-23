<?php

namespace App\Repositories;

use App\Models\DetailInvoiceAvailable;
use App\Models\RelatedTo;

class DetailInvoiceAvailableRepository extends BaseRepository
{
    public function __construct(DetailInvoiceAvailable $modelo)
    {
        parent::__construct($modelo);
    }
    
}
