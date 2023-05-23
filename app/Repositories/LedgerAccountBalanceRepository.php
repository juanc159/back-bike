<?php

namespace App\Repositories;

use App\Models\LedgerAccountBalance;

class LedgerAccountBalanceRepository extends BaseRepository
{
    public function __construct(LedgerAccountBalance $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [])
    {
        $data = $this->model->where(function ($query) use ($request) {
            /* if(!empty($request["user_id"])){
                $query->where("user_id",$request["user_id"]);
            } */
        });

        if (!empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
    }
}
