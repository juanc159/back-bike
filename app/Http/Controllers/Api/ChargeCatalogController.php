<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChargeCatalog\ChargeCatalogStoreRequest; 
use App\Http\Resources\ChargeCatalogListResource;
use App\Repositories\ChargeCatalogRepository;
use App\Repositories\LedgerAccountGroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ChargeCatalogController extends Controller
{
    private $chargeCatalogRepository;
    private $ledgerAccountGroupRepository;

    public function __construct(ChargeCatalogRepository $chargeCatalogRepository, LedgerAccountGroupRepository $ledgerAccountGroupRepository)
    {
        $this->chargeCatalogRepository = $chargeCatalogRepository;
        $this->ledgerAccountGroupRepository = $ledgerAccountGroupRepository;
    }

    public function list(Request $request)
    {
        $data = $this->chargeCatalogRepository->list($request->all());
        $chargeCatalogs = ChargeCatalogListResource::collection($data);
        return [
            'chargeCatalogs' => $chargeCatalogs,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(ChargeCatalogStoreRequest $request) 
    {
        try {
            DB::beginTransaction();
            $data = $this->chargeCatalogRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->chargeCatalogRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->chargeCatalogRepository->find($id);
            if($data){
                $data->delete();
                $msg = "Registro eliminado correctamente";
            }else $msg = "El registro no existe";
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
            $data = $this->chargeCatalogRepository->find($id);
            if($data){ 
                $msg = "Registro encontrado con éxito";
            }else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "data" => $data,"message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function dataForm()
    { 
        $ledgerAccountGroup =  $this->ledgerAccountGroupRepository->list(request:["typeData" =>"todos"],idsAllowed:[26,27,31]);
        return response()->json(['ledgerAccountGroup'=>$ledgerAccountGroup]);
    }
}
