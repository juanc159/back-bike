<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Resources\InvoiceListSelect2Resource;
use App\Http\Resources\TypesCreditNoteListSelect2Resource;
use App\Repositories\InvoiceRepository;
use App\Repositories\TypesCreditNoteRepository;
use App\Repositories\DianReasonRepository;
use Illuminate\Http\Request;


class CreditNoteController extends Controller
{
    private $invoiceRepository;
    private $typesCreditNoteRepository;
    private $dianReasonRepository;
    
    public function __construct(InvoiceRepository $invoiceRepository, TypesCreditNoteRepository $typesCreditNoteRepository, DianReasonRepository $dianReasonRepository)
    {
        $this->invoiceRepository = $invoiceRepository; 
        $this->typesCreditNoteRepository = $typesCreditNoteRepository; 
        $this->dianReasonRepository = $dianReasonRepository; 
    }

    public function dataForm(Request $request)
    {
        $invoices =  $this->invoiceRepository->list($request->all(), ['typesReceiptInvoice', 'third','user','currency','company']);
        $invoicesList = InvoiceListSelect2Resource::collection($invoices);
        
        $typesCreditNote =  $this->typesCreditNoteRepository->list($request->all());
        $typesCreditNoteList = TypesCreditNoteListSelect2Resource::collection($typesCreditNote);

        $dianReasons =  $this->dianReasonRepository->list($request->all());

        return response()->json([
            'invoicesList_arrayInfo' => $invoicesList,
            'invoicesList_countLinks' => $invoices->lastPage(),

            'typesCreditNoteList_arrayInfo' => $typesCreditNoteList,
            'typesCreditNoteList_countLinks' => $typesCreditNote->lastPage(),

            'dianReasons_arrayInfo' => $dianReasons,
        ]);
    }
    
}
