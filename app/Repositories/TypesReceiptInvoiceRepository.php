<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\TypesReceiptInvoice;
use Throwable;

class TypesReceiptInvoiceRepository extends BaseRepository
{
    public function __construct(TypesReceiptInvoice $modelo)
    {
        parent::__construct($modelo);
    }

    public function list($request = [],$with=[],$select=["*"],$withCount=[])
    {
        $data = $this->model->select($select)->withCount($withCount)->with($with)->where(function ($query) use ($request) {            
            if(!empty($request["company_id"])){
                $query->where("company_id",$request["company_id"]);
            }
        })
        ->where(function ($query) use ($request) {
            if (! empty($request['searchQuery'])) {
                $query->orWhere('voucherCode', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('voucherName', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('titleForDisplay', 'like', '%'.$request['searchQuery'].'%');
                $query->orWhere('resolutionNumberDian', 'like', '%'.$request['searchQuery'].'%');
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
            $path = $request->root() . "/storage/" . $file->store('/companies/company_'.$data->company_id.'/typesReceiptInvoices/typesReceiptInvoice_'.$data->id. $request->input('attachFile'), "public");
            $data->attachFile = $path;
        }

        $data->save();

        return $data;
    }

    public function typesReceiptInvoiceDelete($id)
    {
        try {
            $data = $this->model->find($id);
            $data->phonesTypeReceiptInvoice()->delete();
            $data->chargesAndDiscountsInvoices()->delete();
            $data->detailInvoiceAvailable()->detach();
            $data->delete();
        } catch (Throwable $th) {
            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }

    public function validateNumber($request){
        $value = false;
        $data = $this->model->where(function ($query) use ($request) {            
            if(!empty($request["typesReceiptInvoice_id"])){
                $query->where("id",$request["typesReceiptInvoice_id"]);
            }
            if(!empty($request["company_id"])){
                $query->where("company_id",$request["company_id"]);
            }
        })->first();
        
        if($data){
            $invoice = Invoice::where('typesReceiptInvoice_id',$request["typesReceiptInvoice_id"])->where('company_id',$request["company_id"])->get();
            $total = number_format($data->initialNumbering) + count($invoice);
            $numberFinal = number_format($data->finalNumbering);
            if($total > $numberFinal) $value = true;
        }

        return $value;

    }
    
}
