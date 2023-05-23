<?php

namespace App\Http\Controllers\Api;

use App\Exports\LedgerAccountExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\LedgerAccountClassListResource;
use App\Repositories\LedgerAccountBalanceRepository;
use App\Repositories\LedgerAccountCategoryRepository;
use App\Repositories\LedgerAccountClassRepository;
use Illuminate\Http\Request;
use App\Exports\ThirdExport;
use Maatwebsite\Excel\Facades\Excel;

class LedgerAccountClassController extends Controller
{
    private $ledgerAccountClassRepository;
    private $ledgerAccountCategoryRepository;
    private $ledgerAccountBalanceRepository;

    public function __construct(LedgerAccountClassRepository $ledgerAccountClassRepository,LedgerAccountCategoryRepository $ledgerAccountCategoryRepository,LedgerAccountBalanceRepository $ledgerAccountBalanceRepository)
    {
        $this->ledgerAccountClassRepository = $ledgerAccountClassRepository;
        $this->ledgerAccountCategoryRepository = $ledgerAccountCategoryRepository;
        $this->ledgerAccountBalanceRepository = $ledgerAccountBalanceRepository;
    }

    public function list(Request $request)
    {   
        $ledgerAccountCategory = $this->ledgerAccountCategoryRepository->list(['list']);
        $ledgerAccountBalance = $this->ledgerAccountBalanceRepository->list(['list']);
        $data =  $this->ledgerAccountClassRepository->list($request->all());
        $ledgerAccount = LedgerAccountClassListResource::collection($data);
        return [
            'ledgerAccount' => $ledgerAccount,
            'ledgerAccountCategory' => $ledgerAccountCategory,
            'ledgerAccountBalance' => $ledgerAccountBalance,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function excel(Request $request)
    {
        try {
            $request['typeData'] = 'todos';            
            $data =  $this->ledgerAccountClassRepository->list($request->all());
            $ledgerAccount = LedgerAccountClassListResource::collection($data);
            $fileName = 'ledgerAccount.xlsx';
            $path = $request->root() . '/storage/' . $fileName;
            $excel = Excel::store(new LedgerAccountExport($ledgerAccount), $fileName, 'public');
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
}
