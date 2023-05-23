<?php

namespace App\Repositories;

use App\Models\RoleNew;

class RoleRepository extends BaseRepository
{
    public function __construct(RoleNew $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[])
    {
        $data = $this->model->with($with)->where(function ($query) use ($request) {
            if(!empty($request["name"])){
                $query->whereIn("name",$request["name"]);
            }
            if(!empty($request["guard_name"])){
                $query->where("guard_name",$request["guard_name"]);
            }
            if(!empty($request["description"])){
                $query->where("description",$request["description"]);
            }
            if(!empty($request["company_id"])){
                $query->where("company_id",$request["company_id"]);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('guard_name', 'like', '%'.$request['searchQuery'].'%');
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

        $permissions = $request["permissions"] ?? [];
        unset($request["permissions"]);
        foreach ($request->all() as $key => $value) {
            $data[$key] = $request[$key];
            $data['name'] = $request->name.'_'.$request->company_id;
        }
        $data->save();

        if(count($permissions)>0)
            $data->syncPermissions($permissions);

        return $data;
    }
}
