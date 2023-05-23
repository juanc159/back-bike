<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashReceiptResource;
use App\Http\Resources\ThirdSelect2Resource;
use App\Repositories\CashReceiptRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\LedgerAccountAuxiliaryRepository;
use App\Repositories\PerformARepository;
use App\Repositories\ThirdRepository;
use Illuminate\Http\Request;

class CashReceiptController extends Controller
{

    private $cashReceiptRepository;
    private $thirdRepository;
    private $performARepository;
    private $ledgerAccountAuxiliaryRepository;
    private $currencyRepository;

    public function __construct(CashReceiptRepository $cashReceiptRepository,ThirdRepository $thirdRepository,PerformARepository $performARepository,LedgerAccountAuxiliaryRepository $ledgerAccountAuxiliaryRepository,CurrencyRepository $currencyRepository)
    {
        $this->cashReceiptRepository = $cashReceiptRepository; 
        $this->thirdRepository = $thirdRepository; 
        $this->performARepository = $performARepository; 
        $this->ledgerAccountAuxiliaryRepository = $ledgerAccountAuxiliaryRepository; 
        $this->currencyRepository = $currencyRepository; 
    }

    public function list(Request $request)
    {
        $data =  $this->cashReceiptRepository->list($request->all());
        return  $data;
        $cashReceipt = CashReceiptResource::collection($data);
        $rquest['typeData'] = 'todos';
        $countCashReceipt = $this->cashReceiptRepository->list($request->all());

        return [
            'cashReceipt' => $cashReceipt,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
            'number' => count($countCashReceipt),
        ];
    }

    public function dataForm(Request $request)
    {
        $currencies = $this->currencyRepository->all();        
        $auxSubAux = $this->ledgerAccountAuxiliaryRepository->select2($request);
        $performA = $this->performARepository->all();
        
        $request['typeOfThird'] = 1;
        $customers = $this->thirdRepository->list($request->all(),['typesThirds:id,name']);
        $dataCustomer = ThirdSelect2Resource::collection($customers);


        return response()->json([
            'currencies' => $currencies,
            'performA' => $performA,

            'customers_arrayInfo' => $dataCustomer,
            'customers_countLinks' => $customers->lastPage(),

            'arrayAuxSubAux' => $auxSubAux['arrayInfo'],
            'auxSubAux_countLinks' => $auxSubAux['countLinks'],
        ]);
    }
}
