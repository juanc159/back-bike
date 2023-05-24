<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\PassportAuthLoginRequest;
use App\Http\Requests\Authentication\PassportAuthRegisterRequest;
use App\Repositories\MenuRepository;
use App\Repositories\UserRepository;
use App\Services\MailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class PassportAuthController extends Controller
{
    private $userRepository;

    private $menuRepository;

    private $mailService;

    public function __construct(UserRepository $userRepository, MenuRepository $menuRepository, MailService $mailService)
    {
        $this->userRepository = $userRepository;
        $this->menuRepository = $menuRepository;
        $this->mailService = $mailService;
    }

    public function register(PassportAuthRegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->userRepository->register($request->all());

            $this->mailService->setEmailTo($request->input('email'));
            $this->mailService->setView('Mails.UserOutRegister');
            $this->mailService->setSubject('Registro de usuario');
            $this->mailService->sendMessage();

            DB::commit();

            return response()->json(['code' => 200, 'message' => 'Registro agregado correctamente', 'data' => $data]);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json(['code' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    public function login(PassportAuthLoginRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->attempt($data)) {
            $user = Auth::user();
            $obj['id'] = $user->id;
            $obj['name'] = $user->name;
            $obj['lastName'] = $user->lastName;
            $obj['company_id'] = $user->company_id;
            $obj['company'] = $user->company;
            $obj['role_name'] = $user->role->name;
            $obj['role_id'] = $user->role->id;
            $menu = $this->menuRepository->list(['typeData' => 'todos', 'permissions' => $user->all_permissions->pluck('name')], ['children']);
            foreach ($menu as $key => $value) {
                $arrayMenu[$key]['title'] = $value->title;
                $arrayMenu[$key]['to']['name'] = $value->to;
                $arrayMenu[$key]['icon']['icon'] = $value->icon ?? 'mdi-arrow-right-thin-circle-outline';

                if (! empty($value['children'])) {
                    foreach ($value['children'] as $key2 => $value2) {
                        $arrayMenu[$key]['children'][$key2]['title'] = $value2->title;
                        $arrayMenu[$key]['children'][$key2]['to'] = $value2->to;
                        // $arrayMenu[$key]["children"][$key2]["icon"] = $value2->icon ?? "mdi-arrow-right-thin-circle-outline";
                    }
                }
            }

            return response()->json([
                'token' => $user->createToken('PassportAuth')->accessToken,
                'user' => $obj,
                'permissions' => $user->all_permissions->pluck('name'),
                'menu' => $arrayMenu ?? [],
                'message' => 'Bienvenido',
            ], 200);
        } else {
            return response()->json([
                'error' => 'Unauthorised',
                'message' => 'Credenciales incorrectas',
            ], 401);
        }
    }

    public function userInfo()
    {
        $user = Auth::user();

        return response()->json(['user' => $user], 200);
    }
}
