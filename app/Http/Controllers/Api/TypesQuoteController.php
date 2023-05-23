<?php

namespace App\Http\Controllers\Api;

use App\Exports\TypesQuoteExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\TypesQuote\TypesQuoteStoreRequest;
use App\Http\Resources\TypesQuoteListResource;
use App\Http\Resources\TypesQuoteListSelect2Resource;
use App\Repositories\DetailQuoteAvailablesRepository;
use App\Repositories\DiscountPerItemRepository;
use App\Repositories\FormatDisplayPrintInvoiceRepository;
use App\Repositories\TypesQuoteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class TypesQuoteController extends Controller
{
    private $typesQuoteRepository;   
    private $discountPerItemRepository;
    private $formatDisplayPrintInvoiceRepository;
    private $detailQuoteAvailablesRepository;
    public function __construct(
        TypesQuoteRepository $typesQuoteRepository,
        DiscountPerItemRepository $discountPerItemRepository,
        FormatDisplayPrintInvoiceRepository $formatDisplayPrintInvoiceRepository,
        DetailQuoteAvailablesRepository $detailQuoteAvailablesRepository,
        )
    {
        $this->typesQuoteRepository = $typesQuoteRepository;   
        $this->discountPerItemRepository = $discountPerItemRepository; 
        $this->formatDisplayPrintInvoiceRepository = $formatDisplayPrintInvoiceRepository;
        $this->detailQuoteAvailablesRepository = $detailQuoteAvailablesRepository;
    }

    public function list(Request $request)
    {     
        $data =  $this->typesQuoteRepository->list($request->all());
        $typesQuotes = TypesQuoteListResource::collection($data);
         
        return [ 
            'typesQuotes' => $typesQuotes,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(TypesQuoteStoreRequest $request)
    {
        try { 
            $arrayDataDetailQuoteVisualizes = json_decode($request['arrayDataDetailQuoteVisualizes']);
            unset($request['arrayDataDetailQuoteVisualizes']); 
            unset($request['detail_quote_visualizes']); 
            DB::beginTransaction();
            $data = $this->typesQuoteRepository->store($request);
             
            if (!empty($arrayDataDetailQuoteVisualizes) && count($arrayDataDetailQuoteVisualizes) > 0) {
                $arrayD = array_column($arrayDataDetailQuoteVisualizes,'id');
                $data->detailQuoteVisualizes()->sync($arrayD);
            }   
             

            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage(), "line" => $th->getLine()], 500);
        } 
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->typesQuoteRepository->find(id:$id,with:['detailQuoteVisualizes']);

            DB::commit();
            return response()->json(["code" => 200, "data" => $data, "files"=> $data->files]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function dataForm(Request $request)
    {  
        $discountPerItem = $this->discountPerItemRepository->all();
        $formatDisplayPrintInvoice = $this->formatDisplayPrintInvoiceRepository->all();  
        $detailQuoteAvailables = $this->detailQuoteAvailablesRepository->all();  
        return response()->json([ 
            'discountPerItem' => $discountPerItem,
            'formatDisplayPrintInvoice' => $formatDisplayPrintInvoice,
            'detailQuoteAvailables' => $detailQuoteAvailables,
        ]);
    } 
 

    public function excel(Request $request)
    {
        try {
            unset($request['typeData']);
            $data =  $this->typesQuoteRepository->list($request->all());
            $TypesReceiptInvoice = TypesQuoteListResource::collection($data);
            $fileName = 'TypesQuote.xlsx';
            $path = $request->root() . '/storage/' . $fileName;
            $excel = Excel::store(new TypesQuoteExport($TypesReceiptInvoice), $fileName, 'public');
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

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->typesQuoteRepository->typesQuoteDelete($id);
            DB::commit();
            return response()->json(["code" => 200, "message" => "Registro eliminado correctamente"]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function select2InfiniteList(Request $request)
    {
        $data =  $this->typesQuoteRepository->list($request->all());
        $typesQuotes = TypesQuoteListSelect2Resource::collection($data);
        return [
            'typesQuotes_arrayInfo' => $typesQuotes,
            'typesQuotes_countLinks' => $data->lastPage(),
        ];
    }
}
