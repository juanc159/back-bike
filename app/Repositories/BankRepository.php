<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Models\PaymentMethod;

class BankRepository extends BaseRepository
{
    public function __construct(Bank $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$idsAllowed=[],$idsNotAllowed=[])
    {
        $data = $this->model->where(function ($query) use ($request) { 
            if (! empty($request['id'])) {
                $query->where('id', $request['id']);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
            }
        })
        ->where(function ($query) use ($idsAllowed,$idsNotAllowed) {
            if (count($idsAllowed)>0) {
                $query->whereIn('id', $idsAllowed);
            }
            if (count($idsNotAllowed)>0) {
                $query->whereNotIn('id', $idsNotAllowed);
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
    
}
