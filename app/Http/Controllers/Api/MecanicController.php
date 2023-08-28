<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mecanic\MecanicStoreRequest;
use App\Http\Resources\IncomeVehicleListResource;
use App\Http\Resources\MecanicInfoResource;
use App\Http\Resources\MecanicListResource;
use App\Repositories\CompanyRepository;
use App\Repositories\IncomeVehicleRepository;
use App\Repositories\MecanicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MecanicController extends Controller
{
    private $mecanicRepository;
    private $incomeVehicleRepository;
    private $companyRepository;

    public function __construct(
        MecanicRepository $mecanicRepository,
        IncomeVehicleRepository $incomeVehicleRepository,
        CompanyRepository $companyRepository,
    ) {
        $this->mecanicRepository = $mecanicRepository;
        $this->incomeVehicleRepository = $incomeVehicleRepository;
        $this->companyRepository = $companyRepository;
    }

    public function list(Request $request)
    {
        $data = $this->mecanicRepository->list($request->all());
        $mecanics = MecanicListResource::collection($data);
        return [
            'mecanics' => $mecanics,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(MecanicStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->mecanicRepository->store($request->all());
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
            $data = $this->mecanicRepository->find($id);
            if ($data) {
                $data->delete();
                $msg = "Registro eliminado correctamente";
            } else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg], 200);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function info(Request $request)
    {
        try {
            $info = $this->mecanicRepository->find($request->input("id"));
            if ($info) {
                $msg = "Registro encontrado con éxito";
            } else $msg = "El registro no existe";

            $data = new MecanicInfoResource($info);

            $filtro = [
                "mecanic_id" => $request->input("id"),
                "dateInitial" => $request->input("dateInitial"),
                "dateFinal" => $request->input("dateFinal"),
                "pay_labor" => "No",
            ];
            $incomeVehiclesNo = $this->incomeVehicleRepository->list($filtro);
            $incomeVehiclesNo = IncomeVehicleListResource::collection($incomeVehiclesNo);

            $filtro = [
                "mecanic_id" => $request->input("id"), 
                "pay_labor" => "Si",
            ];
            $incomeVehiclesSi = $this->incomeVehicleRepository->list($filtro);
            $incomeVehiclesSi = IncomeVehicleListResource::collection($incomeVehiclesSi);


            return response()->json([
                "code" => 200,
                "message" => $msg,
                "data" => $data,
                'incomeVehiclesSi' => $incomeVehiclesSi,
                'incomeVehiclesNo' => $incomeVehiclesNo,
            ], 200);
        } catch (Throwable $th) {
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
    public function pay(Request $request)
    {
        try {
            $mecanic = $this->mecanicRepository->find($request->input("mecanic_id"));

            foreach ($request->input("selected") as $key => $value) {
                $this->incomeVehicleRepository->changeState($value, "Si", "pay_labor");
            }

            $company = $this->companyRepository->find($mecanic->company_id);
            $valueBase = $company->base - $request->input("totalPay");
            $this->companyRepository->changeState($mecanic->company_id, $valueBase, "base");
        } catch (Throwable $th) {
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
