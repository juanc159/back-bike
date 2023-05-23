<?php

namespace App\Repositories;
 
use App\Models\Quote;

class QuoteRepository extends BaseRepository
{
    protected $quoteFileRepository;
    public function __construct(Quote $modelo,QuoteFileRepository $quoteFileRepository)
    {
        parent::__construct($modelo);
        $this->quoteFileRepository = $quoteFileRepository;
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
            if (!empty($request['date_ini'])) {                    
                $query->whereDate('date_elaboration','>=', $request['date_ini']);
            }
            if (!empty($request['date_fin'])) {                    
                $query->whereDate('date_expiration','<=', $request['date_fin']);
            }
            if (!empty($request['statesQuotes_id'])) {                    
                $query->where('statesQuotes_id', $request['statesQuotes_id']);
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
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
    }

    public function store($request){
        $post = $request->all();
        unset($post['quote_products']);
        unset($post['files']);
        for ($i=0; $i < $request->input("cantArrayArchivesEmail"); $i++) {
            unset($post['emailFile'.$i]);
            unset($post['emailFile_delete'.$i]);
            unset($post['emailFile_id'.$i]);
            unset($post['emailFile_name'.$i]);
        }
        unset($post['cantArrayArchivesEmail']);
 
        if (!empty($request["id"]) && $request["id"] != "null") $data = $this->model->find($request["id"]);
        else $data = $this->model::newModelInstance();
        
        foreach ($post as $key => $value) {
            $data[$key] = $post[$key] != "null" ? $post[$key] : null;
        }
        $data->save(); 

        for ($i = 0; $i < $request->input("cantArrayArchivesEmail"); $i++) {
            if ($request->input("emailFile_id" . $i) != 'null' && $request->input("emailFile_delete" . $i) != 'undefined' && $request->input("emailFile_delete" . $i) != '0') {
                $image = $this->quoteFileRepository->find($request->input("emailFile_id" . $i));
                $image->delete();
            }
            if ($request->file("emailFile" . $i)) {
                $file = $request->file("emailFile" . $i);
                $path = $request->root() . "/storage/" . $file->store('/companies/company_' . $data->company_id . '/quotes/quote_' . $data->id . '/' . $request->input("emailFile" . $i), "public");
                $dataImage["quote_id"] =  $data->id;
                $dataImage["path"] = $path;
                $dataImage["name"] = $request->input("emailFile_name" . $i);
                $this->quoteFileRepository->store($dataImage);
            }
        }

        return $data;
    }
    
}
