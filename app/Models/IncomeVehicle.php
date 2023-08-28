<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeVehicle extends Model
{
    use HasFactory;

    public function thirds(){
        return $this->belongsToMany(Third::class,"income_vehicle_thirds","income_vehicle_id","third_id")->withPivot(["amount"]);
    }
}
