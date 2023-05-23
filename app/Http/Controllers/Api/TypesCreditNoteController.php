<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Repositories\TypesCreditNoteRepository;
use App\Repositories\ChargesAndDiscountsCreditNoteRepository;
use App\Repositories\PhoneTypeCreditNoteRepository;
use App\Exports\TypesCreditNoteExport;
use App\Http\Requests\TypesCreditNote\TypesCreditNoteRequest;
use App\Http\Resources\TypesCreditNoteListResource;
use App\Http\Resources\TypesCreditNoteListSelect2Resource;
use App\Repositories\DetailInvoiceAvailableRepository;
use App\Repositories\CityRepository;
use App\Repositories\DepartamentsRepository;
use App\Repositories\DiscountPerItemRepository;
use App\Repositories\LedgerAccountAuxiliaryRepository;
use App\Repositories\TypeChargeAndDiscountRepository;
use App\Repositories\ValidityInMonthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class TypesCreditNoteController extends Controller
{
    private $typesCreditNoteRepository;
    private $departamentsRepository;
    private $cityRepository;
    private $validityInMonthRepository;
    private $discountPerItemRepository;
    private $ledgerAccountAuxiliaryRepository;
    private $typeChargeAndDiscountRepository;
    private $chargesAndDiscountsCreditNoteRepository;
    private $phoneTypeCreditNoteRepository;
    private $detailInvoiceAvailableRepository;
    public function __construct(
        TypesCreditNoteRepository $typesCreditNoteRepository,
        DepartamentsRepository $departamentsRepository,
        CityRepository $cityRepository,
        ValidityInMonthRepository $validityInMonthRepository,
        DiscountPerItemRepository $discountPerItemRepository,
        LedgerAccountAuxiliaryRepository $ledgerAccountAuxiliaryRepository, 
        TypeChargeAndDiscountRepository $typeChargeAndDiscountRepository,
        ChargesAndDiscountsCreditNoteRepository $chargesAndDiscountsCreditNoteRepository,
        PhoneTypeCreditNoteRepository $phoneTypeCreditNoteRepository,
        DetailInvoiceAvailableRepository $detailInvoiceAvailableRepository
    )
    {
        $this->typesCreditNoteRepository = $typesCreditNoteRepository; 
        $this->departamentsRepository = $departamentsRepository; 
        $this->cityRepository = $cityRepository; 
        $this->validityInMonthRepository = $validityInMonthRepository; 
        $this->discountPerItemRepository = $discountPerItemRepository; 
        $this->ledgerAccountAuxiliaryRepository = $ledgerAccountAuxiliaryRepository; 
        $this->typeChargeAndDiscountRepository = $typeChargeAndDiscountRepository; 
        $this->chargesAndDiscountsCreditNoteRepository = $chargesAndDiscountsCreditNoteRepository; 
        $this->phoneTypeCreditNoteRepository = $phoneTypeCreditNoteRepository; 
        $this->detailInvoiceAvailableRepository = $detailInvoiceAvailableRepository;  
    }

    public function list(Request $request)
    {     
        $data =  $this->typesCreditNoteRepository->list($request->all());
        $typesCreditNote = TypesCreditNoteListResource::collection($data);
         
        return [ 
            'typesCreditNote' => $typesCreditNote,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(TypesCreditNoteRequest $request)
    {
        try { 
            $arrayChargesAndDiscounts = json_decode($request['arrayChargesAndDiscounts']);
            $arrayDataDetailVisualizes = json_decode($request['arrayDataDetailVisualizes']);
            $arrayPhone = json_decode($request['arrayPhone']);
            unset($request['arrayChargesAndDiscounts']);
            unset($request['arrayPhone']);
            unset($request['arrayDataDetail_CreditNote']);
            unset($request['charges_and_discounts_credit_note']);
            unset($request['phones_type_credit_note']);
            unset($request['detail_credit_note_available']);
            unset($request['arrayDataDetailVisualizes']); 
            unset($request['detail_visualizes']); 

            DB::beginTransaction();
            $data = $this->typesCreditNoteRepository->store($request);

            if (!empty($arrayDataDetailVisualizes) && count($arrayDataDetailVisualizes) > 0) {
                $arrayD = array_column($arrayDataDetailVisualizes,'id');
                $data->detailVisualizes()->sync($arrayD);
            } 
            
            if (count($arrayChargesAndDiscounts) > 0) {                
                foreach ($arrayChargesAndDiscounts as $key => $value) {
                    if (isset($value->delete)) {
                        $this->chargesAndDiscountsCreditNoteRepository->delete($value->id);
                    } else {
                        unset($value->delete);
                        $value->type_credit_note_id = $data->id;
                        $value->company_id = $request['company_id'];
                        $this->chargesAndDiscountsCreditNoteRepository->store($value);
                    }
                }
            }
            if (count($arrayPhone) > 0) {
                foreach ($arrayPhone as $key => $value) {
                    if (isset($value->delete)) {
                        $this->phoneTypeCreditNoteRepository->delete($value->id);
                    } else {
                        unset($value->delete);
                        $value->type_credit_note_id = $data->id;
                        $value->company_id = $request['company_id'];
                        $this->phoneTypeCreditNoteRepository->store($value);
                    }
                }
            } 
       

            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage(), "line" => $th->getLine()], 500);
        }
        return $this->typesCreditNoteRepository->store($request);
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->typesCreditNoteRepository->find(id:$id,with:['phonesTypeCreditNote', 'chargesAndDiscountsCreditNote','DetailVisualizes', 'files']);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage(), "line" => $th->getLine()], 500);
        }
    }

    public function dataForm(Request $request)
    {
        $departaments = $this->departamentsRepository->all();
        $validityInMonths = $this->validityInMonthRepository->all();
        $discountPerItem = $this->discountPerItemRepository->all();
        $typeChargeAndDiscount = $this->typeChargeAndDiscountRepository->all();
        $dataDetailInvoiceAvailable = $this->detailInvoiceAvailableRepository->all();
        return response()->json([
            'departaments' => $departaments,
            'validityInMonths' => $validityInMonths,
            'discountPerItem' => $discountPerItem,
            'typeChargeAndDiscount' => $typeChargeAndDiscount,
            'dataDetailInvoiceAvailable' => $dataDetailInvoiceAvailable,
        ]);
    }
    public function getCities(Request $request)
    {
        $request['typeData'] = 'todos';
        $cities = $this->cityRepository->list($request->all());
        return response()->json([
            'cities' => $cities,
        ]);
    }

    public function listAuxiliaryAndSubAuxiliary(Request $request)
    {
        return $this->ledgerAccountAuxiliaryRepository->select2($request);
    }

    public function excel(Request $request)
    {
        try {
            unset($request['typeData']);
            $data =  $this->typesCreditNoteRepository->list($request->all());
            $TypesReceiptInvoice = TypesCreditNoteListResource::collection($data);
            $fileName = 'TypesReceiptInvoice.xlsx';
            $path = $request->root() . '/storage/' . $fileName;
            $excel = Excel::store(new TypesCreditNoteExport($TypesReceiptInvoice), $fileName, 'public');
            if ($excel) {
                return response()->json(['code' => 200, 'path' => $path],200);
            } else {
                return response()->json(['code' => 500],500);
            }
            return $path;
        } catch (\Throwable $th) {
            return response()->json(['code' => 500],500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->typesCreditNoteRepository->typesCreditNoteDelete($id);
            DB::commit();
            return response()->json(["code" => 200, "message" => "Registro eliminado correctamente"]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function select2InfiniteList(Request $request)
    {
        $data =  $this->typesCreditNoteRepository->list($request->all());
        $typesReceiptInvoices = TypesCreditNoteListSelect2Resource::collection($data);
        return [
            'typesReceiptInvoices_arrayInfo' => $typesReceiptInvoices,
            'typesReceiptInvoices_countLinks' => $data->lastPage(),
        ];
    }
}
