<?php

namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepository extends BaseRepository
{
    public function __construct(Invoice $modelo)
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
            if (! empty($request['customer_id'])) {
                $query->where('customer_id', 'like', '%'.$request['customer_id'].'%');
            }
            if (isset($request['seller_id'])) {                    
                $query->where('seller_id', $request['seller_id']);
            }
            if (isset($request['date_ini']) && isset($request['date_fin'])) {                    
                $query->whereBetween('date_elaboration', [$request['date_ini'],$request['date_fin']]);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {                
                $query->orWhere('date_elaboration', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('number', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('gross_total', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('discount', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('subtotal', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('total_form_payment', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('net_total', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhereHas("user", function ($x) use ($request) {
                    $x->where("name", "like", "%" . $request["searchQuery"] . "%");
                });
                $query->orWhereHas("user", function ($x) use ($request) {
                    $x->where("lastName", "like", "%" . $request["searchQuery"] . "%");
                });
                $query->orWhereHas("third", function ($x) use ($request) {
                    $x->where("name", "like", "%" . $request["searchQuery"] . "%");
                });
                $query->orWhereHas("third", function ($x) use ($request) {
                    $x->where("last_name", "like", "%" . $request["searchQuery"] . "%");
                });
                $query->orWhereHas("currency", function ($x) use ($request) {
                    $x->where("name", "like", "%" . $request["searchQuery"] . "%");
                });
            }
        });

        if (empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 1);
        } else {
            $data = $data->get();
        }
        return $data;
    }

    public function store($request){
        $post = $request->all();
        unset($post['attachFile']);
        if (!empty($request["id"]) && $request["id"] != "null") $data = $this->model->find($request["id"]);
        else $data = $this->model::newModelInstance();
        
        foreach ($post as $key => $value) {
            $data[$key] = $post[$key] != "null" ? $post[$key] : null;
        }
        $data->save(); 
        if ($request->file('attachFile')) {
            $file = $request->file('attachFile');
            $path = $request->root() . "/storage/" . $file->store('/companies/company_'.$data->company_id.'/invoice/invoice_'.$data->id. $request->input('attachFile'), "public");
            $data->attachFile = $path;
        }

        $data->save();

        return $data;
    }
    
}
