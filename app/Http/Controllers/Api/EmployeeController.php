<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Http\Resources\EmployeeListResource;
use App\Repositories\AccountTypeRepository;
use App\Repositories\ArlRepository;
use App\Repositories\BankRepository;
use App\Repositories\ChargeCatalogRepository;
use App\Repositories\CompensationBoxRepository;
use App\Repositories\ContributingSubTypeRepository;
use App\Repositories\ContributingTypeRepository;
use App\Repositories\DepartamentsRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeWorkingInformationRepository;
use App\Repositories\HealthBackgroundRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\PayrollGroupRepository;
use App\Repositories\PensionFundRepository;
use App\Repositories\ReasonRetirementRepository;
use App\Repositories\RiskClassRepository;
use App\Repositories\TypeContractRepository;
use App\Repositories\TypeIdentificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class EmployeeController extends Controller
{
    private $employeeRepository;
    private $typeIdentificationRepository;
    private $departamentsRepository;
    private $paymentMethodRepository;
    private $typeContractRepository;
    private $reasonRetirementRepository;
    private $payrollGroupRepository;
    private $chargeCatalogRepository;
    private $contributingTypeRepository;
    private $contributingSubTypeRepository;
    private $healthBackgroundRepository;
    private $pensionFundRepository;
    private $compensationBoxRepository;
    private $arlRepository;
    private $riskClassRepository;
    private $bankRepository;
    private $accountTypeRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        TypeIdentificationRepository $typeIdentificationRepository,
        DepartamentsRepository $departamentsRepository,
        PaymentMethodRepository $paymentMethodRepository,
        TypeContractRepository $typeContractRepository,
        ReasonRetirementRepository $reasonRetirementRepository,
        PayrollGroupRepository $payrollGroupRepository,
        ChargeCatalogRepository $chargeCatalogRepository,
        ContributingTypeRepository $contributingTypeRepository,
        ContributingSubTypeRepository $contributingSubTypeRepository,
        HealthBackgroundRepository $healthBackgroundRepository,
        PensionFundRepository $pensionFundRepository,
        CompensationBoxRepository $compensationBoxRepository,
        ArlRepository $arlRepository,
        RiskClassRepository $riskClassRepository,
        BankRepository $bankRepository,
        AccountTypeRepository $accountTypeRepository
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->typeIdentificationRepository = $typeIdentificationRepository;
        $this->departamentsRepository = $departamentsRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->typeContractRepository = $typeContractRepository;
        $this->reasonRetirementRepository = $reasonRetirementRepository;
        $this->payrollGroupRepository = $payrollGroupRepository;
        $this->chargeCatalogRepository = $chargeCatalogRepository;
        $this->contributingTypeRepository = $contributingTypeRepository;
        $this->contributingSubTypeRepository = $contributingSubTypeRepository;
        $this->healthBackgroundRepository = $healthBackgroundRepository;
        $this->pensionFundRepository = $pensionFundRepository;
        $this->compensationBoxRepository = $compensationBoxRepository;
        $this->arlRepository = $arlRepository;
        $this->riskClassRepository = $riskClassRepository;
        $this->bankRepository = $bankRepository;
        $this->accountTypeRepository = $accountTypeRepository;
    }

    public function list(Request $request)
    {
        $data = $this->employeeRepository->list($request->all());
        $employees = EmployeeListResource::collection($data);
        return [
            'employees' => $employees,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(EmployeeStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->employeeRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->employeeRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $employee = $this->employeeRepository->find($id);
            if($employee){
                $employee->workingInformation()->delete();
                $employee->delete();
                $msg="Registro eliminado correctamente";
            }else{
                $msg="El registro no existe";
            }
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function basicDataDataForm(Request $request)
    {
        $typeIdentifications = $this->typeIdentificationRepository->all();
        $departaments = $this->departamentsRepository->all();
        $paymentMethods = $this->paymentMethodRepository->list(request:["typeData" =>"todos"],idsAllowed:[2,77,78]); 
        $reasonRetirements = $this->reasonRetirementRepository->all(); 
        $kind_procedures = $this->bankRepository->list(request:["typeData" =>"todos"],idsAllowed:[1,2,3,4]); 
        $banking_entitys = $this->bankRepository->list(request:["typeData" =>"todos"],idsNotAllowed:[1,2,3,4]); 
        $accountTypes = $this->accountTypeRepository->all(); 
        return response()->json([
            'typeIdentifications' => $typeIdentifications,
            'departamentsOfresidence' => $departaments,
            'departamentsOfOffice' => $departaments,
            'paymentMethods' => $paymentMethods,
            'reasonRetirements' => $reasonRetirements,
            'kind_procedures' => $kind_procedures,
            'banking_entitys' => $banking_entitys,
            'accountTypes' => $accountTypes,
        ]);
    }
    public function workingInformationDataForm(Request $request)
    {
        $typeContracts = $this->typeContractRepository->all();
        $reasonRetirements = $this->reasonRetirementRepository->all();
        $payrollGroups = $this->payrollGroupRepository->all();
        $request['typeData'] = "todos";
        $chargeCatalogs = $this->chargeCatalogRepository->list(request:$request->all());

        $contributingTypes = $this->contributingTypeRepository->all();
        $contributingSubTypes = $this->contributingSubTypeRepository->all();
        $healthBackgrounds = $this->healthBackgroundRepository->all();
        $pensionFunds = $this->pensionFundRepository->all();
        $compensationBoxs = $this->compensationBoxRepository->all();
        $arls = $this->arlRepository->all();
        $riskClass = $this->riskClassRepository->all();
        return response()->json([
            'typeContracts' => $typeContracts,
            'reasonRetirements' => $reasonRetirements,
            'payrollGroups' => $payrollGroups,
            'chargeCatalogs' => $chargeCatalogs,
            'contributingTypes' => $contributingTypes,
            'contributingSubTypes' => $contributingSubTypes,
            'healthBackgrounds' => $healthBackgrounds,
            'pensionFunds' => $pensionFunds,
            'compensationBoxs' => $compensationBoxs,
            'arls' => $arls,
            'riskClass' => $riskClass,
        ]);
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->employeeRepository->find($id);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
