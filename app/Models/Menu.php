<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
class Menu extends Model
{
    use HasFactory,SoftDeletes;

    public function children(){
        return $this->hasMany(Menu::class,"father","id");
    }

    public function permissions(){
        return $this->hasMany(Permission::class,'menu_id','id');
    }
}
