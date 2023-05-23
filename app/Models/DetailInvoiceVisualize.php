<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DetailInvoiceVisualize extends Model
{
    use HasFactory,SoftDeletes;

    public function detailInvoiceAvailable(){
        return $this->belongsToMany(DataDetailInvoiceAvailable::class,'detail_invoice_visualizes','type_receipt_invoices_id','type_receipt_invoices_id');
    }
}
