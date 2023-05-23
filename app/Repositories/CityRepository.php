<?php

namespace App\Repositories;

use App\Models\Citie;

class CityRepository extends BaseRepository
{
    public function __construct(Citie $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [])
    {
        $data = $this->model->where(function ($query) use ($request) {
            $query->where("departament_id",$request["departament_id"]);
        });

        if (empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
    }
    
}
