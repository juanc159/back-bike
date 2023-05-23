<?php

namespace App\Http\Controllers\Api;

use App\Exports\InvoiceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceRequest;
use App\Http\Resources\InvoiceListResource;
use App\Http\Resources\InvoiceListSelect2Resource;
use App\Http\Resources\ProductSelect2Resource;
use App\Http\Resources\ThirdSelect2Resource;
use App\Http\Resources\TypesReceiptInvoiceListSelect2Resource;
use App\Http\Resources\UserListSelect2Resource;
use App\Repositories\CurrencyRepository;
use App\Repositories\InvoiceImposedChargeRepository;
use App\Repositories\InvoicePaymentMethodRepository;
use App\Repositories\InvoiceProductRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\InvoiceWithholdingTaxRepository;
use App\Repositories\LedgerAccountAuxiliaryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TaxChargeRepository;
use App\Repositories\ThirdRepository;
use App\Repositories\TypesReceiptInvoiceRepository;
use App\Repositories\UserRepository;
use App\Repositories\WithholdingTaxeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class InvoiceController extends Controller
{
    private $currencyRepository;
    private $typesReceiptInvoiceRepository;
    private $userRepository;
    private $thirdRepository;
    private $taxChargeRepository;
    private $withholdingTaxeRepository;
    private $invoiceRepository;
    private $invoiceProductRepository;
    private $invoicePaymentMethodRepository;
    private $invoiceWithholdingTaxRepository;
    private $invoiceImposedChargeRepository;
    private $productRepository;
    private $ledgerAccountAuxiliaryRepository;

    public function __construct(InvoiceRepository $invoiceRepository,InvoiceProductRepository $invoiceProductRepository,InvoicePaymentMethodRepository $invoicePaymentMethodRepository,CurrencyRepository $currencyRepository,TypesReceiptInvoiceRepository $typesReceiptInvoiceRepository,UserRepository $userRepository,ThirdRepository $thirdRepository,TaxChargeRepository $taxChargeRepository,WithholdingTaxeRepository $withholdingTaxeRepository,InvoiceWithholdingTaxRepository $invoiceWithholdingTaxRepository,InvoiceImposedChargeRepository $invoiceImposedChargeRepository,ProductRepository $productRepository, LedgerAccountAuxiliaryRepository $ledgerAccountAuxiliaryRepository)
    {
        $this->currencyRepository = $currencyRepository; 
        $this->typesReceiptInvoiceRepository = $typesReceiptInvoiceRepository; 
        $this->userRepository = $userRepository; 
        $this->thirdRepository = $thirdRepository; 
        $this->taxChargeRepository = $taxChargeRepository; 
        $this->withholdingTaxeRepository = $withholdingTaxeRepository; 
        $this->invoiceRepository = $invoiceRepository; 
        $this->invoiceProductRepository = $invoiceProductRepository; 
        $this->invoicePaymentMethodRepository = $invoicePaymentMethodRepository; 
        $this->invoiceWithholdingTaxRepository = $invoiceWithholdingTaxRepository; 
        $this->invoiceImposedChargeRepository = $invoiceImposedChargeRepository; 
        $this->productRepository = $productRepository; 
        $this->ledgerAccountAuxiliaryRepository = $ledgerAccountAuxiliaryRepository; 
    }

    public function list(Request $request)
    {
        $data =  $this->invoiceRepository->list($request->all(), ['typesReceiptInvoice', 'third','user','currency','company']);
        $invoices = InvoiceListResource::collection($data);

        return [
            'invoices' => $invoices,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(InvoiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $arrayProducts = json_decode($request['arrayProducts']);
            $arrayWayToPay = json_decode($request['arrayWayToPay']);
            $arrayIva = json_decode($request['arrayIva']);
            $arrayWithholdingTaxe = json_decode($request['arrayWithholdingTaxe']);
            unset($request['arrayProducts']);
            unset($request['invoice_payment_method']);
            unset($request['invoice_products']);
            unset($request['arrayWayToPay']);
            unset($request['arrayIva']);
            unset($request['arrayWithholdingTaxe']);
            if(isset($request['number']) && $request['id'] == 'null'){                
                $validateNumber = $this->typesReceiptInvoiceRepository->validateNumber($request);
                if($validateNumber){
                    return response()->json(["code" => 205, "message" => "Excedio el limite de tipo de factura"]); 
                }
            }
            $data = $this->invoiceRepository->store($request);
            //Factura productos('invoice_products')
            if (count($arrayProducts) > 0) {
                foreach ($arrayProducts as $key => $value) {
                    if (isset($value->delete)) {
                        $this->invoiceProductRepository->delete($value->id);
                    } else {
                        unset($value->delete);
                        $value->invoice_id = $data->id;
                        $this->invoiceProductRepository->store($value);
                    }
                }
            }
            //Factura metodo de pago('invoice_payment_methods')
            if (count($arrayWayToPay) > 0) {
                foreach ($arrayWayToPay as $key => $value) {
                    if (isset($value->delete)) {
                        $this->invoicePaymentMethodRepository->delete($value->id);
                    } else {
                        unset($value->delete);
                        $value->invoice_id = $data->id;
                        $this->invoicePaymentMethodRepository->store($value);
                    }
                }
            }
            
            if (count($arrayIva) > 0) {
                $invoiceImposedCharge['invoice_id'] = $data->id;
                $invoiceImpChar = $this->invoiceImposedChargeRepository->list($invoiceImposedCharge);
                $invoiceImpChar->each(function($value){
                    $value->delete();
                });
                foreach ($arrayIva as $key => $value) {
                        $value->invoice_id = $data->id;
                        $this->invoiceImposedChargeRepository->store($value);
                }
            }
            
            if (count($arrayWithholdingTaxe) > 0) {
                $invoiceWithholdingTax['invoice_id'] = $data->id;
                $invoiceWitTax = $this->invoiceWithholdingTaxRepository->list($invoiceWithholdingTax);
                $invoiceWitTax->each(function($value){
                    $value->delete();
                });
                foreach ($arrayWithholdingTaxe as $key => $value) {
                        $value->invoice_id = $data->id;
                        $this->invoiceWithholdingTaxRepository->store($value);
                }
            }
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage(), 'linea'=> $th->getLine()], 500);
        }
        return $this->invoiceRepository->store($request);
    }
    
    public function dataForm(Request $request)
    {
        $currencys = $this->currencyRepository->all();

        $typesReceiptInvoices = $this->typesReceiptInvoiceRepository->list(request:$request->all(),select:['id','voucherName']);
        $typesReceiptInvoicesCustomer = TypesReceiptInvoiceListSelect2Resource::collection($typesReceiptInvoices);
        
        $users = $this->userRepository->list($request->all(),select:['id','name']);
        $userC = UserListSelect2Resource::collection($users);

        $products =  $this->productRepository->list($request->all());
        $productsC = ProductSelect2Resource::collection($products);
        
        $ledgerAccountAuxiliary = $this->ledgerAccountAuxiliaryRepository->select2($request);
        
        $request['typeOfThird'] = 1;
        $customers = $this->thirdRepository->list($request->all(),['typesThirds:id,name']);
        $dataCustomer = ThirdSelect2Resource::collection($customers);

        $taxCharge = $this->taxChargeRepository->all();
        $withholdingTaxe = $this->withholdingTaxeRepository->all();

        return response()->json([
            'currencys' => $currencys,

            'typesReceiptInvoices_arrayInfo' => $typesReceiptInvoicesCustomer,
            'typesReceiptInvoices_countLinks' => $typesReceiptInvoices->lastPage(),

            'userSeller_arrayInfo' => $userC,
            'userSeller_countLinks' => $users->lastPage(),

            'taxCharge' => $taxCharge,
            'withholdingTaxe' => $withholdingTaxe,

            'customers_arrayInfo' => $dataCustomer,
            'customers_countLinks' => $customers->lastPage(),

            'products_arrayInfo' => $productsC,
            'products_countLinks' => $products->lastPage(),

            'arrayInfo' => $ledgerAccountAuxiliary['arrayInfo'],
            'countLinks' => $ledgerAccountAuxiliary['countLinks'],
        ]);
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->invoiceRepository->find($id, ['invoiceProducts', 'invoicePaymentMethod']);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->invoiceRepository->find($id);
            if($data){
                $data->invoiceProducts()->delete();
                $data->invoicePaymentMethod()->delete();
                $data->invoiceImposedCharges()->delete();
                $data->invoiceWithholdingTaxes()->delete();
                $data->delete();
                $msg = 'Registro eliminado correctamente';
            }else $msg = 'El registro no existe';
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
    public function excel(Request $request)
    {
        try {
            $request['typeData'] = 'todos';
            $data =  $this->invoiceRepository->list($request->all(), []);
            $fileName = 'invoice.xlsx';
            $path = $request->root() . '/storage/' . $fileName;
            $excel = Excel::store(new InvoiceExport($data), $fileName, 'public');
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

    public function automaticNumbering($id){
        $typesReceiptInvoices = $this->typesReceiptInvoiceRepository->find(id:$id,withCount:['invoices']);

        return response()->json([
            'typesReceiptInvoices' => $typesReceiptInvoices
        ]);
    }

    public function select2InfiniteList(Request $request)
    {
        $invoices =  $this->invoiceRepository->list($request->all());
        $invoicesList = InvoiceListSelect2Resource::collection($invoices);
        return [
            'invoicesList_arrayInfo' => $invoicesList,
            'invoicesList_countLinks' => $invoices->lastPage(),
        ];
    }
}
