<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EmployeeWorkingInformation extends Model
{
    use HasFactory,SoftDeletes;

    public function risk_class(){
        return $this->hasOne(RiskClass::class,"id","risk_class_id");
    }
}
