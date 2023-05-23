<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ledgerAccount\GroupStoreRequest;
use App\Http\Resources\LedgerAccountGroupResource;
use App\Repositories\LedgerAccountGroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class LedgerAccountGroupController extends Controller
{
    private $ledgerAccountGroupRepository;

    public function __construct(LedgerAccountGroupRepository $ledgerAccountGroupRepository)
    {
        $this->ledgerAccountGroupRepository = $ledgerAccountGroupRepository;
    }

    public function list(Request $request)
    {
        $data = $this->ledgerAccountGroupRepository->list($request->all());
        $group = LedgerAccountGroupResource::collection($data);
        return [
            'group' => $group,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(GroupStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->ledgerAccountGroupRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->ledgerAccountGroupRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->ledgerAccountGroupRepository->delete($id);
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
            $data = $this->ledgerAccountGroupRepository->find($id);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
