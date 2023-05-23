<?php

namespace App\Repositories;

use App\Models\EmployeeWorkingInformation;

class EmployeeWorkingInformationRepository extends BaseRepository
{
    public function __construct(EmployeeWorkingInformation $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[])
    {
        $data = $this->model->with($with)->where(function ($query) use ($request) {
            if(!empty($request["name"])){
                $query->where("name","like","%".$request["name"]."%");
            } 
        }) 
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
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
        else $data = $this->model;

        foreach ($request as $key => $value) {
            $data[$key] = $request[$key];
        }

        $data->save();

        return $data;
    }
    public function findEmployee($request)
    {
        $data = $this->model->where(function($query) use ($request){
            if(!empty($request["employee_id"])){
                $query->where("employee_id",$request["employee_id"]);
            }
        })->first(); 

        return $data;
    }
}
