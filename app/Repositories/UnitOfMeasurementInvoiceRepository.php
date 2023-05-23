<?php

namespace App\Repositories;

use App\Models\UnitOfMeasurementInvoice;

class UnitOfMeasurementInvoiceRepository extends BaseRepository
{
    public function __construct(UnitOfMeasurementInvoice $modelo)
    {
        parent::__construct($modelo);
    }
    
}
