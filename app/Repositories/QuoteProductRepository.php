<?php

namespace App\Repositories;
 
use App\Models\QuoteProduct;

class QuoteProductRepository extends BaseRepository
{
    public function __construct(QuoteProduct $modelo)
    {
        parent::__construct($modelo);
    }

    public function store($request){
        
        if (!empty($request->id)) $data = $this->model->find($request->id);
        else $data = $this->model::newModelInstance();
        
        foreach ($request as $key => $value) {
            $data[$key] = $request->$key;
        }
        $data->save();

        return $data;
    }
    
}
