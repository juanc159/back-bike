<?php

namespace App\Repositories;

use App\Models\FormatDisplayPrintInvoice;

class FormatDisplayPrintInvoiceRepository  extends BaseRepository
{
    public function __construct(FormatDisplayPrintInvoice $modelo)
    {
        parent::__construct($modelo);
    }
    
}
