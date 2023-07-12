<?php
namespace App\Http\Controllers\Api;

use App\Exports\SaleExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\SaleStoreRequest;
use App\Http\Resources\SaleInfoResource;
use App\Http\Resources\SaleListResource;
use App\Repositories\CompanyRepository;
use App\Repositories\InventoryRepository;
use App\Repositories\SaleRepository;
use App\Repositories\ThirdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    private $saleRepository;
    private $inventoryRepository;
    private $thirdRepository;
    private $companyRepository;

    public function __construct(
        SaleRepository $saleRepository,
        InventoryRepository $inventoryRepository,
        ThirdRepository $thirdRepository,
        CompanyRepository $companyRepository,
        )
    {
        $this->saleRepository = $saleRepository;
        $this->inventoryRepository = $inventoryRepository;
        $this->thirdRepository = $thirdRepository;
        $this->companyRepository = $companyRepository;
    }

    public function list(Request $request)
    {
        $data = $this->saleRepository->list($request->all(),["inventory"]);
        $sales = SaleListResource::collection($data);
        return [
            'sales' => $sales,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(SaleStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $thirds = []; 
            foreach ($request["thirds"] as $object) {
                $thirds[$object['id']] = ['amount' => $object['amount']];
              }

            unset($request["thirds"]);
            $data = $this->saleRepository->store($request->all());
            $data->thirds()->sync($thirds);


            if(!$request->input("id")){
                $company = $this->companyRepository->find($request->input("company_id"));
                $valueBase = $company->base + $request->input("utilities");
                $this->companyRepository->changeState($request->input("company_id"),$valueBase,"base");
            }

            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data],200);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        } 
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->saleRepository->find($id);
            if ($data) {  
                $data->delete();
                $msg = "Registro eliminado correctamente";
            } else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg],200);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $info = $this->saleRepository->find($id,["thirds"]);
            if ($info) {
                $msg = "Registro encontrado con éxito";
            } else $msg = "El registro no existe";
 
            $data = new SaleInfoResource($info);

            

            DB::commit();
            return response()->json(["code" => 200, "data" => $data, "message" => $msg],200);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    } 
    public function dataForm(Request $request)
    {
        try {
            $request["typeData"] = "todos";
            $request["noState"] = ['Vendido'];
            $inventories = $this->inventoryRepository->list($request);
            $thirds = $this->thirdRepository->list($request);
            
            return response()->json(["code" => 200, "inventories" => $inventories, "thirds" => $thirds],200);
        } catch (Throwable $th) { 
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    } 

    public function excel(Request $request)
    {
        try {
            $request['typeData'] = "todos";
            $thirds =  $this->thirdRepository->list(request:$request->all());
            $data =  $this->saleRepository->list(request:$request->all(),with:["inventory","thirds"]);
            // return array_column($thirds->toArray(),'id'); 
            // return $data;
            $fileName = 'products.xlsx';
            $path = $request->root() . '/storage/' . $fileName;  
            $excel = Excel::store(new SaleExport($data,$thirds), $fileName, 'public');
            // return $excel;
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
}
