<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodsResource;
use App\Repositories\PaymentMethodRepository;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    private $paymentMethodRepository;
    public function __construct(PaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository; 
    }

    public function list(Request $request)
    {     
        $data =  $this->paymentMethodRepository->list($request->all());
        $paymentMethods = PaymentMethodsResource::collection($data);
        return [ 
            'paymentMethods' => $paymentMethods, 
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }
}
