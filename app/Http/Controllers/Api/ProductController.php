<?php

namespace App\Http\Controllers\Api;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductsStoreRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSelect2Resource;
use App\Imports\ProductImport;
use App\Repositories\ProductRepository;
use App\Repositories\TaxChargeRepository;
use App\Repositories\TaxClassificationRepository;
use App\Repositories\TypeProductRepository;
use App\Repositories\WithholdingTaxeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ProductController extends Controller
{
    private $typeProductRepository;
    private $productRepository;
    private $taxChargeRepository;
    private $withholdingTaxeRepository;
    private $taxClassificationRepository;
    public function __construct(
        ProductRepository $productRepository,
        TaxChargeRepository $taxChargeRepository,
        TypeProductRepository $typeProductRepository,
        WithholdingTaxeRepository $withholdingTaxeRepository,
        TaxClassificationRepository $taxClassificationRepository,
    ) {
        $this->productRepository = $productRepository;
        $this->typeProductRepository = $typeProductRepository;
        $this->taxChargeRepository = $taxChargeRepository;
        $this->withholdingTaxeRepository = $withholdingTaxeRepository;
        $this->taxClassificationRepository = $taxClassificationRepository;
    }
    public function list(Request $request)
    {
        $data =  $this->productRepository->list($request->all());
        $products = ProductResource::collection($data);
        return [
            'products' => $products,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(ProductsStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->productRepository->store($request);
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage(), "line" => $th->getLine()], 500);
        }
        return $this->productRepository->store($request);
    }


    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->productRepository->find($id);
            if ($data) {
                $data->delete();
                $msg = "Registro eliminado correctamente";
            } else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->productRepository->find(id:$id,with:["images:id,product_id,path"]);
            $arrayImages = $data->images;
            unset($data["images"]);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data,"arrayImages" => $arrayImages]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }


    public function dataForm(Request $request)
    {
        $typeProducts = $this->typeProductRepository->all();
        $taxCharges = $this->taxChargeRepository->all();
        $withholdingTaxes = $this->withholdingTaxeRepository->all();
        $taxClassifications = $this->taxClassificationRepository->all();
        return response()->json([
            'typeProducts' => $typeProducts,
            'taxCharges' => $taxCharges,
            'withholdingTaxes' => $withholdingTaxes,
            'taxClassifications' => $taxClassifications,
        ]);
    }

    public function excel(Request $request)
    {
        try {
            $request['typeData'] = "todos";
            $data =  $this->productRepository->list(request:$request->all(),with:["taxCharge"]);  
            $fileName = 'products.xlsx';
            $path = $request->root() . '/storage/' . $fileName; 
            $excel = Excel::store(new ProductExport($data), $fileName, 'public');
            if ($excel) {
                return response()->json(['code' => 200, 'path' => $path],200);
            } else {
                return response()->json(['code' => 500],500);
            }
            return $path;
        } catch (\Throwable $th) {
            return response()->json(['code' => 500,"message"=> $th->getMessage()],500);
        }
    }

    public function changeState(Request $request){
        try {
            DB::beginTransaction();

            $model = $this->productRepository->changeState($request->input('id'), $request->input('state'),'state');

            ($model->state == 1) ? $msg = 'Activado' : $msg = 'Inactivado';

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Producto ' . $msg . ' con éxito']);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }
    public function select2InfiniteList(Request $request)
    {
        $data =  $this->productRepository->list($request->all());
        $products = ProductSelect2Resource::collection($data);
        return [
            'products_arrayInfo' => $products,
            'products_countLinks' => $data->lastPage(),
        ];
    }

    public function importExcel(Request $request) 
    {
        
        try {
            DB::beginTransaction();

            $file = $request->file('fileExcel');
            $import =  new ProductImport(['company_id'=>$request->input('company_id')]);
            $import->import($file);

            if(count($import->dataErrors) == 0){
                foreach ($import->dataInfo as $key => $value) {
                    $this->productRepository->save($value);
                }
                DB::commit();
            }else{
                DB::rollBack();  
            }

            
            if(count($import->dataErrors) > 0) return response()->json(["code" => 422, "errorsImport" => $import->dataErrors ?? [],"message" => "Ocurrio un error con alguno de los registros", 'dataInfo'=>$import->dataInfo]);
            else return response()->json(["code" => 200, "errorsImport" => [], "message" => "Importado con éxito"]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
