<?php

namespace App\Http\Controllers\Api;

use App\Exports\TypesReceiptInvoiceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\TypesReceiptInvoice\TypesReceiptInvoiceRequest; 
use App\Http\Resources\TypesReceiptInvoiceListResource;
use App\Http\Resources\TypesReceiptInvoiceListSelect2Resource;
use App\Repositories\ChargesAndDiscountsInvoiceRepository;
use App\Repositories\CityRepository;
use App\Repositories\DetailInvoiceAvailableRepository;
use App\Repositories\DepartamentsRepository;
use App\Repositories\DiscountPerItemRepository;
use App\Repositories\FormatDisplayPrintInvoiceRepository;
use App\Repositories\LedgerAccountAuxiliaryRepository;
use App\Repositories\LedgerAccountSubAuxiliaryRepository;
use App\Repositories\PhoneTypeReceiptInvoiceRepository;
use App\Repositories\TypeChargeAndDiscountRepository;
use App\Repositories\TypesReceiptInvoiceRepository;
use App\Repositories\ValidityInMonthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Maatwebsite\Excel\Facades\Excel;

class TypesReceiptInvoiceController extends Controller
{
    private $typesReceiptInvoiceRepository;
    private $departamentsRepository;
    private $cityRepository;
    private $validityInMonthRepository;
    private $discountPerItemRepository;
    private $formatDisplayPrintInvoiceRepository;
    private $ledgerAccountAuxiliaryRepository;
    private $ledgerAccountSubAuxiliaryRepository;
    private $typeChargeAndDiscountRepository;
    private $chargesAndDiscountsInvoiceRepository;
    private $phoneTypeReceiptInvoiceRepository;
    private $detailInvoiceAvailableRepository;
    public function __construct(TypesReceiptInvoiceRepository $typesReceiptInvoiceRepository,DepartamentsRepository $departamentsRepository,CityRepository $cityRepository,ValidityInMonthRepository $validityInMonthRepository,DiscountPerItemRepository $discountPerItemRepository,FormatDisplayPrintInvoiceRepository $formatDisplayPrintInvoiceRepository,LedgerAccountAuxiliaryRepository $ledgerAccountAuxiliaryRepository, LedgerAccountSubAuxiliaryRepository $ledgerAccountSubAuxiliaryRepository,TypeChargeAndDiscountRepository $typeChargeAndDiscountRepository,ChargesAndDiscountsInvoiceRepository $chargesAndDiscountsInvoiceRepository,PhoneTypeReceiptInvoiceRepository $phoneTypeReceiptInvoiceRepository,DetailInvoiceAvailableRepository $detailInvoiceAvailableRepository)
    {
        $this->typesReceiptInvoiceRepository = $typesReceiptInvoiceRepository; 
        $this->departamentsRepository = $departamentsRepository; 
        $this->cityRepository = $cityRepository; 
        $this->validityInMonthRepository = $validityInMonthRepository; 
        $this->discountPerItemRepository = $discountPerItemRepository; 
        $this->formatDisplayPrintInvoiceRepository = $formatDisplayPrintInvoiceRepository; 
        $this->ledgerAccountAuxiliaryRepository = $ledgerAccountAuxiliaryRepository; 
        $this->ledgerAccountSubAuxiliaryRepository = $ledgerAccountSubAuxiliaryRepository; 
        $this->typeChargeAndDiscountRepository = $typeChargeAndDiscountRepository; 
        $this->chargesAndDiscountsInvoiceRepository = $chargesAndDiscountsInvoiceRepository; 
        $this->phoneTypeReceiptInvoiceRepository = $phoneTypeReceiptInvoiceRepository; 
        $this->detailInvoiceAvailableRepository = $detailInvoiceAvailableRepository;  
    }

    public function list(Request $request)
    {     
        $data =  $this->typesReceiptInvoiceRepository->list($request->all());
        $typesReceiptInvoices = TypesReceiptInvoiceListResource::collection($data);
         
        return [ 
            'typesReceiptInvoices' => $typesReceiptInvoices,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(TypesReceiptInvoiceRequest $request)
    {
        try { 
            $arrayChargesAndDiscounts = json_decode($request['arrayChargesAndDiscounts']);
            $arrayPhone = json_decode($request['arrayPhone']);
            $arrayDataDetailInvoiceAvailable = json_decode($request['arrayDataDetailInvoiceAvailable']);
            unset($request['arrayChargesAndDiscounts']);
            unset($request['arrayPhone']);
            unset($request['arrayDataDetailInvoiceAvailable']);
            unset($request['charges_and_discounts_invoices']);
            unset($request['phones_type_receipt_invoice']);
            unset($request['detail_invoice_available']);
            unset($request['invoices_count']);
            DB::beginTransaction();
            $data = $this->typesReceiptInvoiceRepository->store($request);
            
            if (count($arrayChargesAndDiscounts) > 0) {                
                foreach ($arrayChargesAndDiscounts as $key => $value) {
                    if (isset($value->delete)) {
                        $this->chargesAndDiscountsInvoiceRepository->delete($value->id);
                    } else {
                        unset($value->delete);
                        $value->type_receipt_invoices_id = $data->id;
                        $value->company_id = $request['company_id'];
                        $this->chargesAndDiscountsInvoiceRepository->store($value);
                    }
                }
            }
            if (count($arrayPhone) > 0) {
                foreach ($arrayPhone as $key => $value) {
                    if (isset($value->delete)) {
                        $this->phoneTypeReceiptInvoiceRepository->delete($value->id);
                    } else {
                        unset($value->delete);
                        $value->type_receipt_invoices_id = $data->id;
                        $value->company_id = $request['company_id'];
                        $this->phoneTypeReceiptInvoiceRepository->store($value);
                    }
                }
            } 
            if (count($arrayDataDetailInvoiceAvailable) > 0) {
                $arrayD = array_column($arrayDataDetailInvoiceAvailable,'id');
                $data->detailInvoiceAvailable()->sync($arrayD);
            }           

            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->typesReceiptInvoiceRepository->store($request);
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->typesReceiptInvoiceRepository->find(id:$id,with:['phonesTypeReceiptInvoice', 'chargesAndDiscountsInvoices','detailInvoiceAvailable'],withCount:['invoices']);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function dataForm(Request $request)
    {
        $departaments = $this->departamentsRepository->all();
        $validityInMonths = $this->validityInMonthRepository->all();
        $discountPerItem = $this->discountPerItemRepository->all();
        $formatDisplayPrintInvoice = $this->formatDisplayPrintInvoiceRepository->all();
        $typeChargeAndDiscount = $this->typeChargeAndDiscountRepository->all();
        $dataDetailInvoiceAvailable = $this->detailInvoiceAvailableRepository->all();
        return response()->json([
            'departaments' => $departaments,
            'validityInMonths' => $validityInMonths,
            'discountPerItem' => $discountPerItem,
            'formatDisplayPrintInvoice' => $formatDisplayPrintInvoice,
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
            $data =  $this->typesReceiptInvoiceRepository->list($request->all());
            $TypesReceiptInvoice = TypesReceiptInvoiceListResource::collection($data);
            $fileName = 'TypesReceiptInvoice.xlsx';
            $path = $request->root() . '/storage/' . $fileName;
            $excel = Excel::store(new TypesReceiptInvoiceExport($TypesReceiptInvoice), $fileName, 'public');
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
            $this->typesReceiptInvoiceRepository->typesReceiptInvoiceDelete($id);
            DB::commit();
            return response()->json(["code" => 200, "message" => "Registro eliminado correctamente"]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function select2InfiniteList(Request $request)
    {
        $data =  $this->typesReceiptInvoiceRepository->list($request->all());
        $typesReceiptInvoices = TypesReceiptInvoiceListSelect2Resource::collection($data);
        return [
            'typesReceiptInvoices_arrayInfo' => $typesReceiptInvoices,
            'typesReceiptInvoices_countLinks' => $data->lastPage(),
        ];
    }
}
