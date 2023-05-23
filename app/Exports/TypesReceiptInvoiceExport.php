<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TypesReceiptInvoiceExport implements FromView
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        return view('Excel.Export.typesReceiptInvoiceExcel', [
            'data' => $this->data
        ]);
    }
}
