<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\company\CompanyRequest;
use App\Http\Resources\CompanyListResource;
use App\Repositories\CompanyRepository; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CompanyController extends Controller
{
    private $companyRepository;
 

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository; 
    }

    public function list(Request $request)
    {

        $data = $this->companyRepository->list($request->all());
        $companies = CompanyListResource::collection($data);

        return [
            'companies' => $companies,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(CompanyRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->companyRepository->store($request); 
            DB::commit();

            $msg = 'agregado';
            if (! empty($request['id'])) {
                $msg = 'modificado';
            }

            return response()->json(['code' => 200, 'message' => 'Registro '.$msg.' correctamente', 'data' => $data]);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json(['code' => 500, 'message' => $th->getMessage()], 500);
        }

        return $this->companyRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->companyRepository->delete($id);
            DB::commit();

            return response()->json(['code' => 200, 'message' => 'Registro eliminado correctamente']);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json(['code' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->companyRepository->find($id);
            DB::commit();

            return response()->json(['code' => 200, 'data' => $data]);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json(['code' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    public function changeState(Request $request)
    {
        try {
            DB::beginTransaction();

            $model = $this->companyRepository->changeState($request->input('id'), $request->input('state'), 'state');

            ($model->state == 1) ? $msg = 'Activado' : $msg = 'Inactivado';

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Empresa '.$msg.' con éxito']);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }
}
