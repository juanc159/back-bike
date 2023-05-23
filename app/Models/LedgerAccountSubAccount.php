<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LedgerAccountSubAccount extends Model
{
    use HasFactory,SoftDeletes;
    use SoftDeletes;
    public function auxiliaries(){
        return $this->hasMany(LedgerAccountAuxiliary::class,'ledgerAccountSubAccount_id','id')->orderBy("code","asc");
    }
}
