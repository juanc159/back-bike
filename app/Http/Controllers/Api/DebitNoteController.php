<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Resources\InvoiceListSelect2Resource;
use App\Repositories\InvoiceRepository;
use Illuminate\Http\Request;


class DebitNoteController extends Controller
{
    private $invoiceRepository;
    
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository; 
    }

    public function dataForm(Request $request)
    {
        $invoices =  $this->invoiceRepository->list($request->all(), ['typesReceiptInvoice', 'third','user','currency','company']);
        $invoicesList = InvoiceListSelect2Resource::collection($invoices);

        return response()->json([
            'invoicesList_arrayInfo' => $invoicesList,
            'invoicesList_countLinks' => $invoices->lastPage(),
        ]);
    }
    
}
