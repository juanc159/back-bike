<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LedgerAccountClass extends Model
{
    use HasFactory,SoftDeletes;

    public function group(){
        return $this->hasMany(LedgerAccountGroup::class,'ledgerAccountClass_id','id')->orderBy("code","asc");
    }
}
