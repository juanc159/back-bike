<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory,SoftDeletes;

    public function third(){
        return $this->hasOne(third::class,'id','customer_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','seller_id');
    }
    public function currency(){
        return $this->hasOne(Currency::class,'id','currency_id');
    }
    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function typeQuote(){
        return $this->hasOne(TypesQuote::class,'id','typesQuote_id');
    }

    public function quoteProducts(){
        return $this->hasMany(QuoteProduct::class,'quote_id','id');
    }
    public function quoteImposedCharges(){
        return $this->hasMany(QuoteImposedCharge::class,'quote_id','id');
    }
    public function quoteWithholdingTaxes(){
        return $this->hasMany(QuoteWithholdingTax::class,'quote_id','id');
    }

    public function files(){
        return $this->hasMany(QuoteFile::class,'quote_id','id');
    }

    public function state(){
        return $this->hasOne(StatesQuote::class,'id','statesQuotes_id');
    }
}
