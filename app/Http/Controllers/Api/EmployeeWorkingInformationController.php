<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeWorkingInformationRequest;
use App\Http\Resources\EmployeeWorkingInformationResource;
use App\Repositories\EmployeeWorkingInformationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class EmployeeWorkingInformationController extends Controller
{
    private $employeeWorkingInformationRepository;

    public function __construct(EmployeeWorkingInformationRepository $employeeWorkingInformationRepository)
    {
        $this->employeeWorkingInformationRepository = $employeeWorkingInformationRepository;
    }

    public function list(Request $request)
    {
        $data = $this->employeeWorkingInformationRepository->list($request->all());
        $employeeWorkingInformation = EmployeeWorkingInformationResource::collection($data);
        return [
            'employeeWorkingInformation' => $employeeWorkingInformation,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }
    
    public function store(EmployeeWorkingInformationRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->employeeWorkingInformationRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->employeeWorkingInformationRepository->store($request);
    } 

    public function info($employee_id)
    {
        try {
            DB::beginTransaction();
            $data = $this->employeeWorkingInformationRepository->findEmployee(["employee_id"=>$employee_id]);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->employeeWorkingInformationRepository->find($id);
            if($data){
                $data->delete();
                $msg = 'Registro eliminado correctamente';
            }else $msg = 'El registro no existe';
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
