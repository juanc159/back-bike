<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository extends BaseRepository
{
    public function __construct(Company $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [])
    {
        $data = $this->model->where(function ($query) use ($request) {
            if(!empty($request["user_id"])){
                $query->where("user_id",$request["user_id"]);
            }
            if(!empty($request["name"])){
                $query->whereIn("name",$request["name"]);
            }
            if(!empty($request["email"])){
                $query->where("email",$request["email"]);
            }
            if(!empty($request["nit"])){
                $query->where("nit",$request["nit"]);
            }
            if(!empty($request["phone"])){
                $query->where("phone",$request["phone"]);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('email', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('nit', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('phone', 'like', '%'.$request['searchQuery'].'%');
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


        unset($data['logo']);

        foreach ($request->all() as $key => $value) {
            $data[$key] = $request[$key] != "null" ? $request[$key] : null;
        }

        $data->save();
        if ($request->file('logo')) {
            $file = $request->file('logo');
            $path = $request->root() . "/storage/" . $file->store('users/user_'.$data->user_id.'/company/company_'.$data->id.'/logo/' . $request->input('logo'), "public");
            $data->logo = $path;
        }

        $data->save();

        return $data;
    }
}
