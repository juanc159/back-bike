<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Resources\RoleListResource;
use App\Http\Resources\UserListResource;
use App\Http\Resources\UserListSelect2Resource;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class Usercontroller extends Controller
{
    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function list(Request $request)
    {
        $data = $this->userRepository->list($request->all(),["role"]);
        $user = UserListResource::collection($data);
        return [
            'user' => $user,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ]; 
    }

    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->userRepository->store($request);
            unset($data['deleted_at']);
            unset($data['whoYouAre']);
            unset($data['email_verified_at']);
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->userRepository->find($id);
            if($data){
                $data->delete();
                $msg = "Registro eliminado correctamente";
            }else $msg="El registro no existe";
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
            $data = $this->userRepository->find($id,[],["id","name","lastName","email","role_id","photo","phone","identification"]);
            if($data){
                $msg = "El registro si existe";
            }else $msg="El registro no existe"; 

            return response()->json(["code" => 200, "data" => $data, "message" => $msg]);
        } catch (Throwable $th) { 
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function dataForm(Request $request)
    {
        $request['typeData'] = 'todos';
        $data =  $this->roleRepository->list($request->all());
        $roles = RoleListResource::collection($data);
        return response()->json(['roles' => $roles]);
    }

    public function changeState(Request $request){
        try {
            DB::beginTransaction();

            $model = $this->userRepository->changeState($request->input('id'), $request->input('state'),'state');

            ($model->state == 1) ? $msg = 'Activado' : $msg = 'Inactivado';

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Usuario ' . $msg . ' con éxito']);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }

    public function select2InfiniteList(Request $request)
    {
        $data =  $this->userRepository->list(request:$request->all());
        $users = UserListSelect2Resource::collection($data);
        return [ 
            'users' => $users,
            'userSeller_arrayInfo' => $users,
            'userSeller_countLinks' => $data->lastPage(),
        ];
    }
}
