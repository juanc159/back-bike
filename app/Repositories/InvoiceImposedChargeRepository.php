<?php

namespace App\Repositories;

use App\Models\InvoiceImposedCharge;

class InvoiceImposedChargeRepository  extends BaseRepository
{
    public function __construct(InvoiceImposedCharge $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[])
    {
        $data = $this->model->with($with)->where(function ($query) use ($request) {            
            if(!empty($request["invoice_id"])){
                $query->where("invoice_id",$request["invoice_id"]);
            }
        })
        ->where(function ($query) use ($request) {                
            if (! empty($request['name'])) {
                $query->where('name', 'like', '%'.$request['name'].'%');
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('last_name', 'like', '%'.$request['searchQuery'].'%');
            }
        });

        if (empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
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
