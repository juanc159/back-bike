<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LedgerAccountGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function account(){
        return $this->hasMany(LedgerAccountAccount::class,'ledgerAccountGroup_id','id')->orderBy("code","asc");
    }
}
