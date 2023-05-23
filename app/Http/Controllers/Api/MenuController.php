<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\MenuRequest;
use App\Http\Resources\MenuListResource;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MenuController extends Controller
{
    private $companyRepository;

    public function __construct(MenuRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function list(Request $request)
    {
        $data = $this->companyRepository->list($request->all());
        $menu = MenuListResource::collection($data);
        return [
            'menu' => $menu,
            'data' => $data,
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(MenuRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->companyRepository->store($request);
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->companyRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->companyRepository->find($id);
            if($data){
                $data->delete();
                $msg = "Registro eliminado correctamente";
            }else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->companyRepository->find($id);
            if($data){
                $msg = "El registro existe";
            }else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "data" => $data , "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }
}
