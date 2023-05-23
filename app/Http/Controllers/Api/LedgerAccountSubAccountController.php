<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ledgerAccount\SubAccountStoreRequest;
use App\Http\Resources\LedgerAccountSubAccountResource;
use App\Repositories\LedgerAccountSubAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class LedgerAccountSubAccountController extends Controller
{
    private $ledgerAccountSubAccountRepository;

    public function __construct(LedgerAccountSubAccountRepository $ledgerAccountSubAccountRepository)
    {
        $this->ledgerAccountSubAccountRepository = $ledgerAccountSubAccountRepository;
    }

    public function list(Request $request)
    {
        $data = $this->ledgerAccountSubAccountRepository->list($request->all());
        $group = LedgerAccountSubAccountResource::collection($data);
        return [
            'group' => $group,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(SubAccountStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->ledgerAccountSubAccountRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->ledgerAccountSubAccountRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->ledgerAccountSubAccountRepository->delete($id);
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
            $data = $this->ledgerAccountSubAccountRepository->find($id);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
