<?php

namespace App\Repositories;

use App\Models\Third;

class ThirdRepository extends BaseRepository
{
    public function __construct(Third $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[])
    {
        $data = $this->model->with($with)->where(function ($query) use ($request) {            
            if(!empty($request["company_id"])){
                $query->where("company_id",$request["company_id"]);
            }
        })
        ->where(function ($query) use ($request) {                
            if (! empty($request['name'])) {
                $query->where('name', 'like', '%'.$request['name'].'%');
            }
            if (isset($request['state'])) {                    
                $query->where('state', $request['state']);
            }
            if (isset($request['identifications'])) {                    
                $query->where('identifications', $request['identifications']);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('last_name', 'like', '%'.$request['searchQuery'].'%');
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['typeOfThird'])) {
                $query->whereHas('typesThirds', function ($query) use ($request) {
                    $query->where('type_of_third_id', $request['typeOfThird']);
                });
            }
        });

        if (empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
    }

    public function store($request){
        if (!empty($request["id"])) $data = $this->model->find($request["id"]);
        else $data = $this->model::newModelInstance();
        
        foreach ($request as $key => $value) {
            $data[$key] = $request[$key];
        }
        $data->save();

        return $data;
    }
    
}
