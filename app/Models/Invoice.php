<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function typesReceiptInvoice(){
        return $this->hasOne(typesReceiptInvoice::class,'id','typesReceiptInvoice_id');
    }
    public function third(){
        return $this->hasOne(third::class,'id','customer_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','seller_id');
    }
    public function currency(){
        return $this->hasOne(Currency::class,'id','currency_id');
    }
    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }


    public function invoiceProducts(){
        return $this->hasMany(InvoiceProduct::class,'invoice_id','id');
    }
    public function invoicePaymentMethod(){
        return $this->hasMany(InvoicePaymentMethod::class,'invoice_id','id');
    }
    public function invoiceImposedCharges(){
        return $this->hasMany(InvoiceImposedCharge::class,'invoice_id','id');
    }
    public function invoiceWithholdingTaxes(){
        return $this->hasMany(InvoiceWithholdingTax::class,'invoice_id','id');
    }
}
