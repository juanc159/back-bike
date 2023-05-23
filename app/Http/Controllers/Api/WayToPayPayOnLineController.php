<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WayToPay\WayToPayPayOnLineRequest;
use App\Http\Resources\WayToPayPayOnLineListResource;
use App\Repositories\WayToPayPayOnLineRepository;
use App\Repositories\LedgerAccountAuxiliaryRepository;
use App\Repositories\RelatedToRepository;
use App\Repositories\PaymentMethodRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;


class WayToPayPayOnLineController extends Controller
{
    
    private $wayToPayPayOnLineRepository;
    private $relatedToRepository;
    private $paymentMethodRepository;
    private $LedgerAccountAuxiliaryRepository;

    public function __construct(WayToPayPayOnLineRepository $wayToPayPayOnLineRepository,RelatedToRepository $relatedToRepository,PaymentMethodRepository $paymentMethodRepository,LedgerAccountAuxiliaryRepository $LedgerAccountAuxiliaryRepository)
    {
        $this->wayToPayPayOnLineRepository = $wayToPayPayOnLineRepository;
        $this->relatedToRepository = $relatedToRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->LedgerAccountAuxiliaryRepository = $LedgerAccountAuxiliaryRepository;
    }

    public function list(Request $request)
    {     
        $data =  $this->wayToPayPayOnLineRepository->list($request->all(),['relatedTo','ledgerAccountAuxiliary','paymentMethod']);
        $relatedTo =  $this->relatedToRepository->all(); 
        $payOnLines = WayToPayPayOnLineListResource::collection($data); 
        return [
            'relatedTo' => $relatedTo, 
            'payOnLines' => $payOnLines,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(WayToPayPayOnLineRequest $request)
    {
        try {
            DB::beginTransaction(); 
            $data = $this->wayToPayPayOnLineRepository->store($request->all());
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->wayToPayPayOnLineRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->wayToPayPayOnLineRepository->find($id);
            if($data){
                $data->delete();
                $msg = "Registro eliminado correctamente";
            }else $msg = "El registro no existe";
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
            $data = $this->wayToPayPayOnLineRepository->find($id);
            if($data){
                $msg = "Registro encontrado con éxito";
            }else $msg = "El registro no existe";

            DB::commit();
            return response()->json(["code" => 200, "data" => $data, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function changeState(Request $request){
        try {
            DB::beginTransaction();

            $model = $this->wayToPayPayOnLineRepository->changeState($request->input('id'), $request->input('in_use'),'in_use');

            ($model->in_use == 1) ? $msg = 'Activado' : $msg = 'Inactivado';

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'General ' . $msg . ' con éxito']);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }
}
