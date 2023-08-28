<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mecanic extends Model
{
    use HasFactory;

    public function incomeVehicles(){
        return $this->hasMany(IncomeVehicle::class,"mecanic_id","id");
    }
}
