<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    public function files(){
        return $this->hasMany(PublicationFile::class,"publication_id","id")->orderBy("order","asc");
    }
}
