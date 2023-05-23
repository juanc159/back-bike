<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WayToPay\WayToPayGeneralRequest;
use App\Http\Resources\WayToPayGeneralListResource;
use App\Repositories\LedgerAccountAuxiliaryRepository;
use App\Repositories\WayToPayGeneralRepository;
use App\Repositories\RelatedToRepository;
use App\Repositories\PaymentMethodRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class WayToPayGeneralController extends Controller
{
    private $wayToPaygeneralRepository;
    private $relatedToRepository;
    private $paymentMethodRepository;
    private $LedgerAccountAuxiliaryRepository;

    public function __construct(WayToPayGeneralRepository $wayToPaygeneralRepository,RelatedToRepository $relatedToRepository,PaymentMethodRepository $paymentMethodRepository,LedgerAccountAuxiliaryRepository $LedgerAccountAuxiliaryRepository)
    {
        $this->wayToPaygeneralRepository = $wayToPaygeneralRepository;
        $this->relatedToRepository = $relatedToRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->LedgerAccountAuxiliaryRepository = $LedgerAccountAuxiliaryRepository;
    }

    public function list(Request $request)
    {     
        $data =  $this->wayToPaygeneralRepository->list($request->all(),['relatedTo','ledgerAccountAuxiliary','paymentMethod']); 
        $relatedTo =  $this->relatedToRepository->all(); 
        $generals = WayToPayGeneralListResource::collection($data);
         
        return [
            'relatedTo' => $relatedTo, 
            'generals' => $generals,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }
    

    public function store(WayToPayGeneralRequest $request)
    {

        try {
            DB::beginTransaction();
            $data = $this->wayToPaygeneralRepository->store($request);
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->wayToPaygeneralRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction(); 
            $data = $this->wayToPaygeneralRepository->find($id);
            if($data){
                $data->delete();
                $msg = "Registro eliminado correctamente";
            }else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg]);

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
            $data = $this->wayToPaygeneralRepository->find($id);
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

            $model = $this->wayToPaygeneralRepository->changeState($request->input('id'), $request->input('in_use'),'in_use');

            ($model->in_use == 1) ? $msg = 'Activado' : $msg = 'Inactivado';

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'General ' . $msg . ' con éxito']);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }
}
