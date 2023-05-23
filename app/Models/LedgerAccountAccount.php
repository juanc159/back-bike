<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
class LedgerAccountAccount extends Model
{
    use HasFactory,SoftDeletes;
    use SoftDeletes;
    public function subAccount(){
        return $this->hasMany(LedgerAccountSubAccount::class,'ledgerAccountAccount_id','id')->orderBy("code","asc");
    }
}
