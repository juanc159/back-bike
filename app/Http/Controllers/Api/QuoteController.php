<?php

namespace App\Http\Controllers\Api;

use App\Exports\QuoteExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quote\QuoteStoreRequest;
use App\Http\Resources\CurrencySelect2Resource;
use App\Http\Resources\ProductSelect2Resource;
use App\Http\Resources\QuoteListResource;
use App\Http\Resources\ThirdSelect2Resource;
use App\Http\Resources\TypesQuoteListSelect2Resource;
use App\Http\Resources\UserListSelect2Resource;
use App\Repositories\CurrencyRepository;
use App\Repositories\InvoiceImposedChargeRepository;
use App\Repositories\InvoicePaymentMethodRepository;
use App\Repositories\InvoiceProductRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\ProductRepository;
use App\Repositories\QuoteImposedChargeRepository;
use App\Repositories\QuoteProductRepository;
use App\Repositories\QuoteRepository;
use App\Repositories\QuoteWithholdingTaxRepository;
use App\Repositories\StatesQuoteRepository;
use App\Repositories\TaxChargeRepository;
use App\Repositories\ThirdRepository;
use App\Repositories\TypesQuoteRepository;
use App\Repositories\UserRepository;
use App\Repositories\WithholdingTaxeRepository;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class QuoteController extends Controller
{
    private $currencyRepository;
    private $userRepository;
    private $thirdRepository;
    private $taxChargeRepository;
    private $withholdingTaxeRepository;
    private $quoteRepository;
    private $quoteProductRepository;
    private $quoteWithholdingTaxRepository;
    private $quoteImposedChargeRepository;
    private $productRepository;
    private $typesQuoteRepository;
    private $mailService;
    private $statesQuoteRepository;
    private $invoiceRepository;
    private $invoiceProductRepository;
    private $invoicePaymentMethodRepository;
    private $invoiceImposedChargeRepository;

    public function __construct(
        TypesQuoteRepository $typesQuoteRepository,
        QuoteRepository $quoteRepository,
        QuoteProductRepository $quoteProductRepository,
        CurrencyRepository $currencyRepository,
        UserRepository $userRepository,
        ThirdRepository $thirdRepository,
        TaxChargeRepository $taxChargeRepository,
        WithholdingTaxeRepository $withholdingTaxeRepository,
        QuoteWithholdingTaxRepository $quoteWithholdingTaxRepository,
        QuoteImposedChargeRepository $quoteImposedChargeRepository,
        ProductRepository $productRepository,
        MailService $mailService,
        StatesQuoteRepository $statesQuoteRepository,
        InvoiceRepository $invoiceRepository,
        InvoiceProductRepository $invoiceProductRepository,
        InvoicePaymentMethodRepository $invoicePaymentMethodRepository,
        InvoiceImposedChargeRepository $invoiceImposedChargeRepository,
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->userRepository = $userRepository;
        $this->thirdRepository = $thirdRepository;
        $this->taxChargeRepository = $taxChargeRepository;
        $this->withholdingTaxeRepository = $withholdingTaxeRepository;
        $this->quoteRepository = $quoteRepository;
        $this->quoteProductRepository = $quoteProductRepository;
        $this->quoteWithholdingTaxRepository = $quoteWithholdingTaxRepository;
        $this->quoteImposedChargeRepository = $quoteImposedChargeRepository;
        $this->productRepository = $productRepository;
        $this->typesQuoteRepository = $typesQuoteRepository;
        $this->mailService = $mailService;
        $this->statesQuoteRepository = $statesQuoteRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceProductRepository = $invoiceProductRepository;
        $this->invoicePaymentMethodRepository = $invoicePaymentMethodRepository;
        $this->invoiceImposedChargeRepository = $invoiceImposedChargeRepository;
    }

    public function list(Request $request)
    {
        $data =  $this->quoteRepository->list($request->all(), ['state', 'typeQuote', 'third', 'user', 'currency', 'company']);
        $quotes = QuoteListResource::collection($data);

        return [
            'quotes' => $quotes,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(QuoteStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $arrayProducts = json_decode($request['arrayProducts']);
            $arrayIva = json_decode($request['arrayIva']);
            $arrayWithholdingTaxe = json_decode($request['arrayWithholdingTaxe']);
            unset($request['arrayProducts']);
            unset($request['arrayIva']);
            unset($request['arrayWithholdingTaxe']);

            $data = $this->quoteRepository->store($request);
            if (count($arrayProducts) > 0) {
                foreach ($arrayProducts as $key => $value) {
                    if (isset($value->delete)) {
                        $this->quoteProductRepository->delete($value->id);
                    } else {
                        unset($value->delete);
                        $value->quote_id = $data->id;
                        $this->quoteProductRepository->store($value);
                    }
                }
            }

            if (count($arrayIva) > 0) {
                $quoteImposedCharge['quote_id'] = $data->id;
                $quoteImpChar = $this->quoteImposedChargeRepository->list($quoteImposedCharge);
                $quoteImpChar->each(function ($value) {
                    $value->delete();
                });
                foreach ($arrayIva as $key => $value) {
                    $value->quote_id = $data->id;
                    $this->quoteImposedChargeRepository->store($value);
                }
            }

            if (count($arrayWithholdingTaxe) > 0) {
                $quoteWithholdingTax['quote_id'] = $data->id;
                $quoteWitTax = $this->quoteWithholdingTaxRepository->list($quoteWithholdingTax);
                $quoteWitTax->each(function ($value) {
                    $value->delete();
                });
                foreach ($arrayWithholdingTaxe as $key => $value) {
                    $value->quote_id = $data->id;
                    $this->quoteWithholdingTaxRepository->store($value);
                }
            }
            DB::commit();


            //envio de correos
            $dataEmails = [
                // Auth::user()->email,
                "jcmg.ing@gmail.com",
                $this->thirdRepository->find($request->input("customer_id"))->email_fac,
                $this->userRepository->find($request->input("seller_id"))->email,
            ];
            $arrayFiles = array_column($data->files->toArray(), 'path');
            $typesQuote = $this->typesQuoteRepository->find($request->input("typesQuote_id"));
            $this->mailService->setView("Mails.QuoteRegister");
            $this->mailService->setSubject($typesQuote->subjectMail);
            $this->mailService->setFile($arrayFiles);
            foreach ($dataEmails as $key => $value) {
                $this->mailService->setEmailTo($value);
                $this->mailService->sendMessage([
                    "content" => $typesQuote->contentMail
                ]);
            }

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage(), 'linea' => $th->getLine()], 500);
        }
    }

    public function dataForm(Request $request)
    {

        $statesQuotes = $this->statesQuoteRepository->all();

        $typesQuotes = $this->typesQuoteRepository->list($request->all());
        $typesQuotesC = TypesQuoteListSelect2Resource::collection($typesQuotes);

        $users = $this->userRepository->list($request->all(), select: ['id', 'name']);
        $userC = UserListSelect2Resource::collection($users);

        $products =  $this->productRepository->list($request->all());
        $productsC = ProductSelect2Resource::collection($products);

        $currencies =  $this->currencyRepository->list($request->all());
        $currenciesC = CurrencySelect2Resource::collection($currencies);


        $request['typeOfThird'] = 1;
        $customers = $this->thirdRepository->list($request->all(), ['typesThirds:id,name']);
        $dataCustomer = ThirdSelect2Resource::collection($customers);

        $taxCharge = $this->taxChargeRepository->all();
        $withholdingTaxe = $this->withholdingTaxeRepository->all();

        return response()->json([
            'statesQuotes' => $statesQuotes,

            'typesQuotes_arrayInfo' => $typesQuotesC,
            'typesQuotes_countLinks' => $typesQuotes->lastPage(),

            'currencies_arrayInfo' => $currenciesC,
            'currencies_countLinks' => $currencies->lastPage(),


            'userSeller_arrayInfo' => $userC,
            'userSeller_countLinks' => $users->lastPage(),

            'taxCharge' => $taxCharge,
            'withholdingTaxe' => $withholdingTaxe,

            'customers_arrayInfo' => $dataCustomer,
            'customers_countLinks' => $customers->lastPage(),

            'products_arrayInfo' => $productsC,
            'products_countLinks' => $products->lastPage(),
        ]);
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->quoteRepository->find($id, ['quoteProducts', "files"]);
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

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->quoteRepository->find($id);
            if ($data) {
                $data->quoteProducts()->delete();
                $data->quoteImposedCharges()->delete();
                $data->quoteWithholdingTaxes()->delete();
                $data->delete();
                $msg = 'Registro eliminado correctamente';
            } else $msg = 'El registro no existe';
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
            $data =  $this->quoteRepository->list($request->all(), []);
            $fileName = 'quote.xlsx';
            $path = $request->root() . '/storage/' . $fileName;
            $excel = Excel::store(new QuoteExport($data), $fileName, 'public');
            if ($excel) {
                return response()->json(['code' => 200, 'path' => $path], 200);
            } else {
                return response()->json(['code' => 500], 500);
            }
            return $path;
        } catch (\Throwable $th) {
            return response()->json(['code' => 500], 500);
        }
    }

    public function automaticNumbering($id)
    {
        $typesQuote = $this->typesQuoteRepository->find(id: $id, withCount: ['quotes']);

        return response()->json([
            'typesQuote' => $typesQuote
        ]);
    }

    public function changeState(Request $request)
    {
        try {
            DB::beginTransaction();

            $state = $this->statesQuoteRepository->find($request->input('statesQuotes_id'));
            if ($state) {
                $this->quoteRepository->changeState($request->input('id'), $request->input('statesQuotes_id'), 'statesQuotes_id');
                $msg = $state->name;
            } else {
                return response()->json(['code' => 500, 'msg' => 'El estado no existe'], 422);
            }

            DB::commit();
            return response()->json(['code' => 200, 'msg' => 'Registro ' . $msg . ' con éxito']);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }
    public function toInvoice(Request $request)
    {
        try {
            DB::beginTransaction();
            $quote = $this->quoteRepository->changeState($request->input('quoute_id'), 2, 'statesQuotes_id',['quoteProducts','quoteImposedCharges']);
            

            $invoice = null;
            unset($quote["id"]);
            unset($quote["statesQuotes_id"]);
            unset($quote["typesQuote_id"]);
            unset($quote["date_expiration"]);
            $quote["typesReceiptInvoice_id"] = 1;
            $quote["total_form_payment"] = 0;
            $quoteProducts = $quote->quoteProducts;
            unset($quote["quoteProducts"]);
            $quoteImposedCharges = $quote->quoteImposedCharges;
            unset($quote["quoteImposedCharges"]);
            

            $data = $this->invoiceRepository->newModelInstance();
            foreach ($quote->toArray() as $key => $value) {
                $data[$key] = $value;
            }
            $invoice = $this->invoiceRepository->save($data); 


            if (count($quoteProducts) > 0) {  
                foreach ($quoteProducts as $key => $value) { 
                    unset($value["updated_at"]);
                    unset($value["created_at"]);
                    unset($value["id"]);
                    unset($value["quote_id"]);
                    $value["invoice_id"] = $invoice->id;
                    $data = $this->invoiceProductRepository->newModelInstance(); 
                    foreach ($value->toArray() as $key => $value) {
                        $data[$key] = $value;
                    }   
                    $this->invoiceProductRepository->save($data);
                }
            }
 
            if (count($quoteImposedCharges) > 0) {  
                foreach ($quoteImposedCharges as $key => $value) { 
                    unset($value["updated_at"]);
                    unset($value["created_at"]);
                    unset($value["id"]);
                    unset($value["quote_id"]);
                    $value["invoice_id"] = $invoice->id;
                    $data = $this->invoiceImposedChargeRepository->newModelInstance(); 
                    foreach ($value->toArray() as $key => $value) {
                        $data[$key] = $value;
                    }   
                    $this->invoiceImposedChargeRepository->save($data);
                }
            }

            $arrayWayToPay = json_decode($request->input('arrayWayToPay'),true); 
            if (count($arrayWayToPay) > 0) {  
                foreach ($arrayWayToPay as $key => $value) { 
                    unset($value["delete"]); 
                    unset($value["id"]); 
                    $value["invoice_id"] = $invoice->id;
                    $data = $this->invoicePaymentMethodRepository->newModelInstance(); 
                    foreach ($value as $key => $value) {
                        $data[$key] = $value;
                    }   
                    $this->invoicePaymentMethodRepository->save($data);
                }
            } 

            DB::commit();
            return response()->json(['code' => 200, 'msg' => 'Registro Aprobado con éxito', "invoice" => $invoice]);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage(), 'line' => $th->getLine()]);
        }
    }
}
