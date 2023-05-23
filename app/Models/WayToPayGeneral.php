<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WayToPayGeneral extends Model
{
    use HasFactory,SoftDeletes;

    public function relatedTo(){
        return $this->hasOne(RelatedTo::class,'id','related_to_id');
    }
    public function ledgerAccountAuxiliary(){
        return $this->hasOne(LedgerAccountAuxiliary::class,'id','ledger_account_auxiliary_id');
    }
    public function paymentMethod(){
        return $this->hasOne(PaymentMethod::class,'id','payment_method_id');
    }
}
