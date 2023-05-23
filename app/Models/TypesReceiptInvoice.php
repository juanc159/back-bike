<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypesReceiptInvoice extends Model
{
    use HasFactory,SoftDeletes;

    public function phonesTypeReceiptInvoice(){
        return $this->hasMany(PhoneTypeReceiptInvoice::class,'type_receipt_invoices_id','id');
    }
    public function chargesAndDiscountsInvoices(){
        return $this->hasMany(ChargesAndDiscountsInvoice::class,'type_receipt_invoices_id','id');
    }
    public function detailInvoiceAvailable(){
        return $this->belongsToMany(DetailInvoiceAvailable::class,'detail_invoice_visualizes','type_receipt_invoices_id','detail_invoice_availables_id');
    }
    public function invoices(){
        return $this->hasMany(Invoice::class,'typesReceiptInvoice_id','id');
    }
}

