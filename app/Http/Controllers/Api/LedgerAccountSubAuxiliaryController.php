<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubAuxiliary\SubAuxiliaryStoreRequest;
use App\Http\Resources\LedgerAccountSubAuxiliaryResource;
use App\Repositories\LedgerAccountSubAuxiliaryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class LedgerAccountSubAuxiliaryController extends Controller
{
    private $ledgerAccountSubAuxiliaryRepository;

    public function __construct(LedgerAccountSubAuxiliaryRepository $ledgerAccountSubAuxiliaryRepository)
    {
        $this->ledgerAccountSubAuxiliaryRepository = $ledgerAccountSubAuxiliaryRepository;
    }

    public function list(Request $request)
    {
        $data = $this->ledgerAccountSubAuxiliaryRepository->list($request->all());
        $group = LedgerAccountSubAuxiliaryResource::collection($data);
        return [
            'group' => $group,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(SubAuxiliaryStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->ledgerAccountSubAuxiliaryRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->ledgerAccountSubAuxiliaryRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->ledgerAccountSubAuxiliaryRepository->delete($id);
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
            $data = $this->ledgerAccountSubAuxiliaryRepository->find($id);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
