<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SaleExport implements FromView
{
    private $data;
    private $thirds;
    public function __construct($data,$thirds)
    { 
        $this->data = $data; 
        $this->thirds = $thirds; 
    }
    
    public function view(): View
    {    
        return view('Excel.Export.SalesExcel', [
            'data' => $this->data,
            'thirds' => $this->thirds,
            "prueba" => array_column($this->thirds->toArray(),'id')
        ]);
    }
}
