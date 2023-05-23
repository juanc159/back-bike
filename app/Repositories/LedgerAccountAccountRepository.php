<?php

namespace App\Repositories;

use App\Models\LedgerAccountAccount; 

class LedgerAccountAccountRepository extends BaseRepository
{
    public function __construct(LedgerAccountAccount $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [])
    {
        $data = $this->model->where(function ($query) use ($request) {
            
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                //$query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
            }
        })
        ->orderBy($request["sort_field"] ?? "id",$request["sort_direction"] ?? 'asc');

        if (empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
    }

    public function store($request)
    {
        if (!empty($request["id"])) $data = $this->model->find($request["id"]);
        else {
            $existCode = $this->model->where('code',$request['code'])->where(function($query) use ($request){
                $query->where('company_id',$request["company_id"])
                        ->OrWhereNull('company_id');
            })->get();
            if(count($existCode) > 0){
                return 401;
            }else{
                $data = $this->model;
            }
        }

        foreach ($request  as $key => $value) {
            $data[$key] = $request[$key];
        }

        $data->save();

        return $data;
    }

    
}
