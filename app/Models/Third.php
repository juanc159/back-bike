<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Third extends Model
{
    use HasFactory,SoftDeletes;

    public function fiscalResponsabilityThirds(){
        return $this->belongsToMany(FiscalResponsability::class,'fiscal_responsability_thirds','third_id','fiscal_responsabilities_id');
    }
    public function phonesThirds(){
        return $this->hasMany(PhonesThird::class,'third_id','id');
    }
    public function contactsThirds(){
        return $this->hasMany(ContactsThird::class,'third_id','id');
    }
    public function typeIdentificaction(){
        return $this->hasOne(TypeIdentification::class,'id','type_identifications_id');
    }
    public function typeRegimenIva(){
        return $this->hasOne(TypeRegimeIva::class,'id','type_regime_ivas_id');
    }
    public function typesThirds(){
        return $this->belongsToMany(TypeOfThird::class,'third_type_thirds','third_id','type_of_third_id');
    }
}
