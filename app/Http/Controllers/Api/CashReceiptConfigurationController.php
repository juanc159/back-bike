<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CashReceiptConfiguration\CashReceiptConfigurationStoreRequest;
use App\Http\Resources\CashReceiptConfigurationListResource;
use App\Repositories\CashReceiptConfigurationRepository;
use App\Repositories\LedgerAccountAuxiliaryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CashReceiptConfigurationController extends Controller
{
    private $cashReceiptConfigurationRepository;
    private $ledgerAccountAuxiliaryRepository;

    public function __construct(CashReceiptConfigurationRepository $cashReceiptConfigurationRepository, LedgerAccountAuxiliaryRepository $ledgerAccountAuxiliaryRepository)
    {
        $this->cashReceiptConfigurationRepository = $cashReceiptConfigurationRepository;
        $this->ledgerAccountAuxiliaryRepository = $ledgerAccountAuxiliaryRepository;
    }

    public function list(Request $request)
    {
        $data = $this->cashReceiptConfigurationRepository->list($request->all());
        $cashReceiptConfigurations = CashReceiptConfigurationListResource::collection($data);
        return [
            'cashReceiptConfigurations' => $cashReceiptConfigurations,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(CashReceiptConfigurationStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->cashReceiptConfigurationRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->cashReceiptConfigurationRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->cashReceiptConfigurationRepository->find($id);
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
            $data = $this->cashReceiptConfigurationRepository->find($id);
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

    public function dataForm(Request $request)
    {
        $ledgerAccountAuxiliary = $this->ledgerAccountAuxiliaryRepository->select2($request);
        return response()->json([
            'arrayInfo' => $ledgerAccountAuxiliary['arrayInfo'],
            'countLinks' => $ledgerAccountAuxiliary['countLinks'],
        ]);
    }
}
