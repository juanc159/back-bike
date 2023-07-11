<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeVehicle\IncomeVehicleStoreRequest;
use App\Http\Resources\IncomeVehicleListResource;
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

    public function __construct(IncomeVehicleRepository $incomeVehicleRepository, MecanicRepository $mecanicRepository, ThirdRepository $thirdRepository)
    {
        $this->incomeVehicleRepository = $incomeVehicleRepository;

        $this->mecanicRepository = $mecanicRepository;

        $this->thirdRepository = $thirdRepository;
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
            $data = $this->incomeVehicleRepository->store($request->all());
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
            if ($data) {
                $msg = "Registro encontrado con éxito";
            } else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "data" => $data, "message" => $msg]);
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
