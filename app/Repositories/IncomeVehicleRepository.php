<?php

namespace App\Repositories;

use App\Models\IncomeVehicle;

class IncomeVehicleRepository extends BaseRepository
{
    public function __construct(IncomeVehicle $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[])
    {
        $data = $this->model->with($with)->where(function ($query) use ($request) {
            if(!empty($request["name"])){
                $query->where("name","like","%".$request["name"]."%");
            } 
            if(!empty($request["state"])){
                $query->where("state","like","%".$request["state"]."%");
            } 
            if(!empty($request["noState"])){
                $query->whereNotIn("state", $request["noState"]);
            } 
        }) 
        ->where(function ($query) use ($request) {
            if(!empty($request["company_id"])){
                $query->where("company_id",$request["company_id"]);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('vehicleType', 'like', '%'.$request['searchQuery'].'%');
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
        else $data = $this->model::newModelInstance(); 

        foreach ($request as $key => $value) {
            $data[$key] = $request[$key];
        }

        $data->save();

        return $data;
    }
}
