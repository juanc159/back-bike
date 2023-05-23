<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencySelect2Resource;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private $currencyRepository; 

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository; 
    }
    public function select2InfiniteList(Request $request)
    {
        $data =  $this->currencyRepository->list($request->all());
        $currencies = CurrencySelect2Resource::collection($data);
        return [
            'currencies_arrayInfo' => $currencies,
            'currencies_countLinks' => $data->lastPage(),
        ];
    }
}
