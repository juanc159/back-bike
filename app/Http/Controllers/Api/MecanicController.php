<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mecanic\MecanicStoreRequest;
use App\Http\Resources\MecanicInfoResource;
use App\Http\Resources\MecanicListResource;
use App\Repositories\MecanicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MecanicController extends Controller
{
    private $mecanicRepository;

    public function __construct(
        MecanicRepository $mecanicRepository,
    ) {
        $this->mecanicRepository = $mecanicRepository;
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

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $info = $this->mecanicRepository->find($id);
            if ($info) {
                $msg = "Registro encontrado con éxito";
            } else $msg = "El registro no existe";

            $data = new MecanicInfoResource($info);

            DB::commit();
            return response()->json(["code" => 200, "data" => $data, "message" => $msg], 200);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
