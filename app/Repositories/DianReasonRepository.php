<?php

namespace App\Repositories;

use App\Models\DianReason;

class DianReasonRepository extends BaseRepository
{
    public function __construct(DianReason $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [])
    {
        $data = $this->model;

        if (empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
    }
    
}
