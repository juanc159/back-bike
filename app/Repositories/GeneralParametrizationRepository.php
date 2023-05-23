<?php

namespace App\Repositories;

use App\Models\GeneralParametrization;

class GeneralParametrizationRepository extends BaseRepository
{
    public function __construct(GeneralParametrization $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[],$idsAllowed=[],$idsNotAllowed=[])
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
