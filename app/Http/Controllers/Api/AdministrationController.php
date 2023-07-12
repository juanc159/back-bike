<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\AdministrationStoreRequest;
use App\Http\Resources\AdminitrationListResource;
use App\Repositories\AdministrationRepository;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AdministrationController extends Controller
{
    private $administrationRepository;
    private $companyRepository;

    public function __construct(AdministrationRepository $administrationRepository, CompanyRepository $companyRepository,)
    {
        $this->administrationRepository = $administrationRepository;
        $this->companyRepository = $companyRepository;
    }

    public function list(Request $request)
    {
        $data = $this->administrationRepository->list($request->all());
        $administrations = AdminitrationListResource::collection($data);
        return [
            'administrations' => $administrations,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(AdministrationStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->administrationRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";


            
            if (!$request->input("id") && $request->input("status")==1) {
                $company = $this->companyRepository->find($request->input("company_id"));
                $valueBase = $company->base - $request->input("cost");
                $this->companyRepository->changeState($request->input("company_id"), $valueBase, "base");
            }


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
            $data = $this->administrationRepository->find($id);
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
            $data = $this->administrationRepository->find($id);
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
}
