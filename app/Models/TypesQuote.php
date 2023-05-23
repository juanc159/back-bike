<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypesQuote extends Model
{
    use HasFactory,SoftDeletes;
 

    public function detailQuoteVisualizes(){
        return $this->belongsToMany(DetailQuoteAvailables::class,'detail_quote_visualizes','types_quote_id','detail_quote_available_id');
    }

    public function quotes(){
        return $this->hasMany(Quote::class,'typesQuote_id','id');
    }
    public function files(){
        return $this->hasMany(TypesQuoteFile::class,'typesQuote_id','id');
    }
}