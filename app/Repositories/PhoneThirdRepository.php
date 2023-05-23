<?php

namespace App\Repositories;

use App\Models\PhonesThird;

class PhoneThirdRepository extends BaseRepository
{
    public function __construct(PhonesThird $modelo)
    {
        parent::__construct($modelo);
    }

    public function store($request){
        
        if (!empty($request["id"])) $data = $this->model->find($request["id"]);
        else $data = $this->model::newModelInstance();
        
        foreach ($request as $key => $value) {
            $data[$key] = $request[$key];
        }
        $data->save();

        return $data;
    }
    
}
