<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository
{ 
    public function __construct(Permission $modelo)
    { 
        parent::__construct($modelo);
    }

    public function list($request = [])
    { 
        $data = $this->model->where(function ($query) use ($request) {
            // if(!empty($request[""])){
            //     $query->where("",$request[""]);
            // }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('description', 'like', '%'.$request['searchQuery'].'%');
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
        else $data = $this->model;

        foreach ($request->all() as $key => $value) {
            $data[$key] = $request[$key];
        }

        $data->save();
        return $data;
    }
}
