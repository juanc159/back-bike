<?php

namespace App\Repositories;

use App\Models\DetailQuoteAvailables;
use App\Models\FormatDisplayPrintInvoice;

class DetailQuoteAvailablesRepository  extends BaseRepository
{
    public function __construct(DetailQuoteAvailables $modelo)
    {
        parent::__construct($modelo);
    }
    
}
