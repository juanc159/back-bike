<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeVehicle\IncomeVehicleStoreRequest;
use App\Http\Resources\IncomeVehicleListResource;
use App\Repositories\CompanyRepository;
use App\Repositories\IncomeVehicleRepository;
use App\Repositories\MecanicRepository;
use App\Repositories\ThirdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class IncomeVehicleController extends Controller
{
    private $incomeVehicleRepository;

    private $mecanicRepository;

    private $thirdRepository;
        private $companyRepository;

    public function __construct(IncomeVehicleRepository $incomeVehicleRepository, MecanicRepository $mecanicRepository, ThirdRepository $thirdRepository,CompanyRepository $companyRepository)
    {
        $this->incomeVehicleRepository = $incomeVehicleRepository;

        $this->mecanicRepository = $mecanicRepository;

        $this->thirdRepository = $thirdRepository;
                $this->companyRepository = $companyRepository;
    }

    public function list(Request $request)
    {
        $data = $this->incomeVehicleRepository->list($request->all());
        $incomeVehicles = IncomeVehicleListResource::collection($data);
        return [
            'incomeVehicles' => $incomeVehicles,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(IncomeVehicleStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $post = $request->all();
            unset($request["thirds"]);
            unset($request["arrayNoDelete"]);
            if(empty($request->input("id"))){
                $request["state"] = "Ingresado";
            }
            $data = $this->incomeVehicleRepository->store($request->all());

            if (!$request->input("id")) {
                $company = $this->companyRepository->find($request->input("company_id"));
                $valueBase = $company->base + $request->input("value_labor");
                $this->companyRepository->changeState($request->input("company_id"), $valueBase, "base");
            }

            $thirds = [];
            foreach ($post["arrayNoDelete"] as $key => $value) {
                $thirds[$value["type_id"]] = [
                    "amount" => str_replace('.','',$value["amount"])
                ];
            }

            $data->thirds()->sync($thirds);

            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->incomeVehicleRepository->find($id);
            if ($data) {
                $data->thirds()->detach(); 
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
            $data = $this->incomeVehicleRepository->find($id);
            $thirds=[];
            if ($data) {
                $msg = "Registro encontrado con éxito";
                $thirds= $data->thirds->map(function($value){
                    return [
                        "type_id" => $value->id,
                        "name" => $value->name,
                        "amount" => $value->pivot?->amount,
                    ];
                });
            } else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "data" => $data,"thirds"=>$thirds, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
    public function changeState(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->incomeVehicleRepository->changeState($request->input("id"), $request->input("state"), "state");
            if ($data) {
                $msg = "Registro modificado con éxito";
            } else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "data" => $data, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function dataForm(Request $request)
    {
        try {
            $request['typeData'] = 'all';

            $operatives = $this->mecanicRepository->list($request->all());

            $typeArrangement = $this->thirdRepository->list($request->all());

            return response()->json(["code" => 200, "operatives" => $operatives, 'typeArrangement' => $typeArrangement]);
        } catch (\Throwable $th) {
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
