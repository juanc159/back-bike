<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payroll extends Model
{
    use HasFactory,SoftDeletes;

    public function employees(){
        return $this->hasMany(PayrollEmployee::class,"payroll_id","id");
    }
}
