<?php

namespace App\Repositories;

use App\Models\LedgerAccountAuxiliary;

class LedgerAccountAuxiliaryRepository extends BaseRepository
{
    public $ledgerAccountSubAuxiliaryRepository;
    public function __construct(LedgerAccountAuxiliary $modelo,LedgerAccountSubAuxiliaryRepository $ledgerAccountSubAuxiliaryRepository)
    {
        parent::__construct($modelo);
        $this->ledgerAccountSubAuxiliaryRepository = $ledgerAccountSubAuxiliaryRepository;
    }

    public function list($request = [])
    {
        $data = $this->model->where(function ($query) use ($request) { 
            if (! empty($request['company_id']) && $request['company_id'] !== 'null') {
                $query->where('company_id', $request['company_id']);
            } 
            if (!empty($request['company_id']) && $request['company_id'] === 'null') {
                $query->whereNull('company_id');
            } 
            if (! empty($request['id'])) {
                $query->orWhere('id', $request['id']);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('name', 'like', '%'.$request['searchQuery'].'%');
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
        else $data = $this->model::newModelInstance();
        
        foreach ($request  as $key => $value) {
            $data[$key] = $request[$key];
        }

        $data->save();
        return $data;
    }

    public function select2($request){
        $data = $this->list($request->all());
        $data1 = $this->ledgerAccountSubAuxiliaryRepository->list($request->all());
        $id = 0;
        $dataNueva = [];
        foreach ($data as $key => $value) {
            $id++;
            $dataNueva[] = [
                'id' => $value->id,
                'pos' => $id,
                'name' => $value->name,
                'company_id' => $value->company_id,
                'table' => 'ledger_account_auxiliaries',
                'nameCode' => $value->code.' - '.$value->name
            ];
        }
        $dataNueva2 = [];
        foreach ($data1 as $key => $value) {
            $id++;
            $dataNueva2[] = [
                'id' => $value->id,
                'pos' => $id,
                'name' => $value->name,
                'company_id' => $value->company_id,
                'table' => 'ledger_account_subauxiliaries',
                'nameCode' => $value->code.' - '.$value->name
            ];
        }        
        $arrayInfo = array_merge($dataNueva,$dataNueva2);
        $mayor = $data->lastPage();
        if($mayor < $data1->lastPage()) $mayor = $data1;
        return [
            'arrayInfo' => $arrayInfo,
            'countLinks' => $mayor,
        ];
    }

    
}
