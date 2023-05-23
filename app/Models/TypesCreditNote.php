<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypesCreditNote extends Model
{
    use HasFactory, SoftDeletes;

    public function phonesTypeCreditNote(){
        return $this->hasMany(PhoneTypeCreditNote::class,'type_credit_note_id','id');
    }
    public function chargesAndDiscountsCreditNote(){
        return $this->hasMany(ChargesAndDiscountsCreditNote::class,'type_credit_note_id','id');
    }

    public function DetailVisualizes(){
        return $this->belongsToMany(DetailInvoiceAvailable::class,'detail_credit_visualizes','type_credit_note_id','detail_invoice_availables_id');
    }

    public function files(){
        return $this->hasMany(TypesCreditNoteFile::class,'typesCreditNotes_id','id');
    }
}
