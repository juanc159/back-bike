<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\InventoryRepository;
use App\Repositories\SaleRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $inventoryRepository;
    private $saleRepository;


    public function __construct(InventoryRepository $inventoryRepository, SaleRepository $saleRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
        $this->saleRepository = $saleRepository;
    }

    public function index(Request $request)
    {

        $inventories = $this->inventoryRepository->list(["company_id" => 1]);
        $salesData = $this->saleRepository->list(["company_id" => 1]);
        $shoppings = 0;
        $sales = 0;
        $thirds = 0;
        $utilities = 0;
        if (!empty($inventories) && count($inventories )>0) {
            foreach ($inventories as $key => $value) {
                $shoppings += $value->purchaseValue;
                $sales += $value->saleValue;
            }
        } 
        if (!empty($salesData) && count($salesData )>0) {
            foreach ($salesData as $key => $value) {
                $thirds += $value->total;
                $utilities += $value->utilities;
            }
        }
        return [
            'shoppings' => $shoppings,
            'sales' => $sales,
            'thirds' => $thirds,
            'utilities' => $utilities,
        ];
    }
}
