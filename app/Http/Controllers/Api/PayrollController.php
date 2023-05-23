<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\PayrollStoreRequest;
use App\Http\Resources\GeneralParametrizationResource;
use App\Http\Resources\PayrollEmployeeResource;
use App\Http\Resources\PayrollResource;
use App\Repositories\EmployeeRepository;
use App\Repositories\GeneralParametrizationRepository;
use App\Repositories\PayrollRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PayrollImport;
use App\Repositories\PayrollEmployeeRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class PayrollController extends Controller
{
    private $payrollRepository;
    private $employeeRepository;
    private $generalParametrizationRepository;
    private $payrollEmployeeRepository;
    public function __construct(
        PayrollRepository $payrollRepository, 
        PayrollEmployeeRepository $payrollEmployeeRepository, 
        EmployeeRepository $employeeRepository, 
        GeneralParametrizationRepository $generalParametrizationRepository, 
    ) {
        $this->payrollRepository = $payrollRepository; 
        $this->payrollEmployeeRepository = $payrollEmployeeRepository; 
        $this->employeeRepository = $employeeRepository; 
        $this->generalParametrizationRepository = $generalParametrizationRepository; 
    }

    public function list(Request $request)
    {
        $data =  $this->payrollRepository->list($request->all());
        $payrolls = PayrollResource::collection($data);

        return [
            'payrolls' => $payrolls,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(PayrollStoreRequest $request)
    {
        try {
            $dataEmployees =$request->input("dataEmployees"); 
            if (!is_array($dataEmployees)) 
                $dataEmployees =json_decode($dataEmployees,true); 

            DB::beginTransaction();
            unset($request["dataEmployees"]);
            $data = $this->payrollRepository->store($request->all());

            if(count($dataEmployees)>0){
                foreach ($dataEmployees as $key => $value) {
                    $value["employee_id"] = $value["id"];
                    $value["payroll_id"] = $data->id;
                    unset($value["id"]); 
                    unset($value["full_name"]); 
                    unset($value["document_number"]); 
                    unset($value["salary"]);
                    unset($value["risk_class_value"]);

                    $extra_hours = str_replace(".", "", $value["extra_hours"]);
                    $value["extra_hours"] = strtr($extra_hours, ",", ".");

                    $bonuses = str_replace(".", "", $value["bonuses"]);
                    $value["bonuses"] = strtr($bonuses, ",", ".");

                    $commissions = str_replace(".", "", $value["commissions"]);
                    $value["commissions"] = strtr($commissions, ",", ".");

                    $other_discounts = str_replace(".", "", $value["other_discounts"]);
                    $value["other_discounts"] = strtr($other_discounts, ",", ".");

                    $data = $this->payrollEmployeeRepository->store($value);
                }
            }

            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getLine(),"message" => $th->getMessage()], 500);
        }
        return $this->payrollRepository->store($request);
    }

    public function dataForm($company_id)
    {
        $generalParametrization = $this->generalParametrizationRepository->all();
        $generalParametrization = GeneralParametrizationResource::collection($generalParametrization);
        return response()->json([ 
            
            'generalParametrization' => $generalParametrization,
        ]);
    }
    public function dataFormRefresh($company_id)
    {
        $employees = $this->employeeRepository->list(request:["typeData" =>"todos","company_id",$company_id],with:["workingInformation"]);
        $employees = PayrollEmployeeResource::collection($employees);
        $years =  $this->payrollRepository->list(request:["typeData" =>"todos","company_id",$company_id],select:["year"]);
        $years = $years->pluck("year")->unique()->toArray(); 
        $years[] = date("Y");
        rsort($years) ;
        return response()->json([
            'years' => $years,
            'employees' => $employees,
        ]);
    }

    public function importExcel(Request $request) 
    {
        
        try {
            DB::beginTransaction();
            $data = $this->payrollRepository->new();
            $data['name'] = $request->input('name');
            $data['settlement_type'] = $request->input('settlement_type');
            $data['month'] = $request->input('month');
            $data['year'] = $request->input('year');
            $data['company_id'] = $request->input('company_id');

            $payroll = $this->payrollRepository->save($data);

            $file = $request->file('fileExcel');
            $import =  new PayrollImport(['payroll_id'=>$payroll->id]);
            $import->import($file);

            if(count($import->dataErrors) == 0){
                foreach ($import->dataInfo as $key => $value) {
                    unset($value['id']);
                    $this->payrollEmployeeRepository->save($value);
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

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->payrollRepository->find($id,["employees"]);
            if($data){
                $data->employees()->delete();
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
            $data = $this->payrollRepository->find($id,["employees"]);
            if($data){
                $msg = "El registro existe";
            }else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "data" => $data , "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
