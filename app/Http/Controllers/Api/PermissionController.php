<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionStoreRequest;
use App\Http\Resources\PermissionListResource;
use App\Repositories\MenuRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PermissionController extends Controller
{
    private $permissionRepository;
    private $menuRepository;

    public function __construct(PermissionRepository $permissionRepository, MenuRepository $menuRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->menuRepository = $menuRepository;
    }

    public function list(Request $request)
    { 
        $data = $this->permissionRepository->list($request->all());
        $permission = PermissionListResource::collection($data);
        return [
            'permission' => $permission,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(PermissionStoreRequest $request)
    {

        try {
            DB::beginTransaction();
            $data = $this->permissionRepository->store($request);
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->permissionRepository->store($request);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->permissionRepository->find($id);
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
            $data = $this->permissionRepository->find($id);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function dataForm()
    {
        $menus =  $this->menuRepository->list(['typeData'=>'todos']);
        return response()->json(['menus' => $menus]);
    }
}
