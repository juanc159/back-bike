<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auxiliary\AuxiliaryStoreRequest;
use App\Http\Resources\LedgerAccountAuxiliaryResource;
use App\Repositories\LedgerAccountAuxiliaryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class LedgerAccountAuxiliaryController extends Controller
{
    private $ledgerAccountAuxiliaryRepository;

    public function __construct(LedgerAccountAuxiliaryRepository $ledgerAccountAuxiliaryRepository)
    {
        $this->ledgerAccountAuxiliaryRepository = $ledgerAccountAuxiliaryRepository;
    }

    public function list(Request $request)
    {
        $data = $this->ledgerAccountAuxiliaryRepository->list($request->all());
        $ledgerAccountAuxiliar = LedgerAccountAuxiliaryResource::collection($data);
        return [
            'ledgerAccountAuxiliar' => $ledgerAccountAuxiliar,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(AuxiliaryStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->ledgerAccountAuxiliaryRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->ledgerAccountAuxiliaryRepository->store($request);
    }

    public function delete($id)
    {
        try {
            $auxiliar = $this->ledgerAccountAuxiliaryRepository->find($id,['subAuxiliaries']);
            DB::beginTransaction();
            $message = "Registro eliminado correctamente";
            if(count($auxiliar->subAuxiliaries) > 0 ) $message = 'Este registro no se pued eliminar por que esta en uso';
            else $this->ledgerAccountAuxiliaryRepository->delete($id);
            DB::commit();
            return response()->json(["code" => 200, "message" => $message]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->ledgerAccountAuxiliaryRepository->find($id);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
