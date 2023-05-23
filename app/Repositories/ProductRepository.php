<?php

namespace App\Repositories;

use App\Models\Product;
use Throwable;

class ProductRepository extends BaseRepository
{
    private $productImageRepository;
    public function __construct(Product $modelo, ProductImageRepository $productImageRepository)
    {
        parent::__construct($modelo);
        $this->productImageRepository = $productImageRepository;
    }

    public function list($request = [], $idsAllowed = [], $idsNotAllowed = [],$with=[])
    {
        $data = $this->model->with($with)->where(function ($query) use ($request) {
            if (!empty($request['typeProduct_id'])) {
                $query->where('typeProduct_id', $request['typeProduct_id']);
            }
            if (!empty($request['name'])) {
                $query->where('name',"like", "%".$request['name']."%");
            }
            if (isset($request['state'])) {                    
                $query->where('state', $request['state']);
            }
        })
            ->where(function ($query) use ($request) {
                if(!empty($request["company_id"])){
                    $query->where("company_id",$request["company_id"]);
                }
            })
            ->where(function ($query) use ($request) {
                if (!empty($request['searchQuery'])) {
                    $query->orWhere('name', 'like', '%' . $request['searchQuery'] . '%');
                    $query->orWhere('factoryReference', 'like', '%' . $request['searchQuery'] . '%');
                    $query->orWhere('description', 'like', '%' . $request['searchQuery'] . '%');
                    $query->orWhereHas("taxCharge", function ($x) use ($request) {
                        $x->where("name", "like", "%" . $request["searchQuery"] . "%");
                    });
                }
            })
            ->where(function ($query) use ($idsAllowed, $idsNotAllowed) {
                if (count($idsAllowed) > 0) {
                    $query->whereIn('id', $idsAllowed);
                }
                if (count($idsNotAllowed) > 0) {
                    $query->whereNotIn('id', $idsNotAllowed);
                }
            })
            ->orderBy($request["sort_field"] ?? "id", $request["sort_direction"] ?? 'asc');

        if (empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
    }

    public function store($request)
    {
        $post = $request->all();
        unset($post['arrayImages']);
        for ($i=0; $i < $request->input("cantImageProducts"); $i++) {
            unset($post['imageProduct'.$i]);
            unset($post['imageProduct_delete'.$i]);
            unset($post['imageProduct_id'.$i]);
        }
        unset($post['cantImageProducts']);
        
        if (!empty($request["id"]) && $request["id"] != "null") $data = $this->model->find($request["id"]);
        else $data = $this->model::newModelInstance();

        foreach ($post as $key => $value) {
            $data[$key] = $post[$key] != "null" ? $post[$key] : null;
        } 
        $data->save();
 
        for ($i=0; $i < $request->input("cantImageProducts"); $i++) {
            if ($request->input("imageProduct_id".$i) != 'null' && $request->input("imageProduct_delete".$i) != 'undefined' && $request->input("imageProduct_delete".$i) != '0'){
                $image = $this->productImageRepository->find($request->input("imageProduct_id".$i));
                $image->delete();
            }
            if ($request->file("imageProduct".$i)) {
                $file = $request->file("imageProduct".$i);
                $path = $request->root() . "/storage/" . $file->store('/companies/company_' . $data->company_id . '/products/product_' . $data->id .'/'. $request->input("imageProduct".$i), "public");
                $dataImage["product_id"] =  $data->id;
                $dataImage["path"] = $path;
                $this->productImageRepository->store($dataImage);
            } 
        } 

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
}
