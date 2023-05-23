<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleNew extends Role
{
    use HasFactory,SoftDeletes;

    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }
}
 