<?php

namespace App\Repositories;

use App\Models\QuoteFile; 

class QuoteFileRepository extends BaseRepository
{
    public function __construct(QuoteFile $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[],$select=["*"],$withCount=[])
    {
        $data = $this->model->select($select)->withCount($withCount)->with($with)->where(function ($query) use ($request) {            
            if(!empty($request["company_id"])){
                $query->where("company_id",$request["company_id"]);
            }
            if(!empty($request["inUse"])){
                $query->where("inUse",$request["inUse"]);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {  
            }
        });

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
