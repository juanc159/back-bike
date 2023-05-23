<?php

namespace App\Repositories;

use App\Models\WayToPayGeneral;

class WayToPayGeneralRepository extends BaseRepository
{
    public function __construct(WayToPayGeneral $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[])
    {
        $data = $this->model->with($with)->where(function ($query) use ($request) {            
            if(!empty($request["company_id"])){
                $query->where("company_id",$request["company_id"]);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('code', 'like', '%'.$request['searchQuery'].'%');
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
        if (!empty($request["id"])) $data = $this->model->find($request["id"]);
        else $data = $this->model;

        foreach ($request->all() as $key => $value) {
            $data[$key] = $request[$key];
        }

        $data->save();

        return $data;
    }
    
}
