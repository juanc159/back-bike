<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory,SoftDeletes;

    public function inventory(){
        return $this->hasOne(Inventory::class,"id","inventory_id");
    }

    public function thirds(){
        return $this->belongsToMany(Third::class,"sale_thirds","sale_id","third_id")->withPivot(["amount"]);
    }
}
