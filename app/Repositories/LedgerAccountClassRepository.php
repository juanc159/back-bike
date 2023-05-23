<?php

namespace App\Repositories;

use App\Models\LedgerAccountClass;

class LedgerAccountClassRepository extends BaseRepository
{
    public function __construct(LedgerAccountClass $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [])
    {        
        $data = $this->model->with(
            [
                'group' => function ($query) use ($request){
                    $query->whereNull('company_id')
                          ->orWhere('company_id',$request['companyId']);
                },
                'group.account' => function ($query) use ($request){
                    $query->whereNull('company_id')
                          ->orWhere('company_id',$request['companyId']);
                },
                'group.account.subAccount' => function ($query) use ($request){
                    $query->whereNull('company_id')
                          ->orWhere('company_id',$request['companyId']);
                },
                'group.account.subAccount.auxiliaries' => function ($query) use ($request){
                    $query->where('company_id',$request['companyId']);
                },
                'group.account.subAccount.auxiliaries.subAuxiliaries' => function ($query) use ($request){
                    $query->orWhere('company_id',$request['companyId']);
                },
            ]  
        )
        ->where(function ($query) use ($request) {            
            if (! empty($request['searchQuery'])) {
                //$query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
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
