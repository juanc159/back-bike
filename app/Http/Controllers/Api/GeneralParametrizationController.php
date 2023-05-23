<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralParametrization\GeneralParametrizationRequest;
use App\Http\Resources\GeneralParametrizationResource;
use App\Repositories\GeneralParametrizationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class GeneralParametrizationController extends Controller
{
    private $generalParametrizationRepository;

    public function __construct(GeneralParametrizationRepository $generalParametrizationRepository)
    {
        $this->generalParametrizationRepository = $generalParametrizationRepository;
    }

    public function list(Request $request)
    {
        $data = $this->generalParametrizationRepository->list($request->all());
        $chargeCatalogs = GeneralParametrizationResource::collection($data);
        return [
            'chargeCatalogs' => $chargeCatalogs,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(GeneralParametrizationRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->generalParametrizationRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->generalParametrizationRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->generalParametrizationRepository->delete($id);
            DB::commit();
            return response()->json(["code" => 200, "message" => "Registro eliminado correctamente"]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->generalParametrizationRepository->find($id);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
