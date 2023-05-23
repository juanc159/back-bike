<?php

namespace App\Repositories;
 
use App\Models\Payroll;

class PayrollRepository extends BaseRepository
{
    public function __construct(Payroll $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$idsAllowed=[],$idsNotAllowed=[],$select=['*'])
    {
        $data = $this->model->select($select)->where(function ($query) use ($request) { 
            if (! empty($request['company_id'])) {
                $query->where('company_id', $request['company_id']);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('year', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('month', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('settlement_type', 'like', '%'.$request['searchQuery'].'%');
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
    
}
