<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Third\ThirdRequest;
use App\Http\Resources\ThirdListResource;
use App\Repositories\BasicDataTypeRepository;
use App\Repositories\ContactThirdRepository;
use App\Repositories\FiscalResponsabilityRepository;
use App\Repositories\FiscalResponsabilityThirdRepository;
use App\Repositories\PhoneThirdRepository;
use App\Repositories\ThirdRepository;
use App\Repositories\TypeIdentificationRepository;
use App\Repositories\TypeOfThirdRepository;
use App\Repositories\TypeRegimeIvaRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Exports\ThirdExport;
use App\Http\Resources\ThirdSelect2Resource;
use App\Repositories\CityRepository;
use App\Repositories\DepartamentsRepository;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ThirdController extends Controller
{
    private $thirdRepository;
    private $basicDataTypeRepository;
    private $fiscalResponsabilityRepository;
    private $typeIdentificationRepository;
    private $typeOfThirdRepository;
    private $typeRegimeIvaRepository;
    private $userRepository;
    private $fiscalResponsabilityThirdRepository;
    private $contactThirdRepository;
    private $phoneThirdRepository;
    private $departamentsRepository;
    private $cityRepository;

    public function __construct(ThirdRepository $thirdRepository, BasicDataTypeRepository $basicDataTypeRepository, FiscalResponsabilityRepository $fiscalResponsabilityRepository, TypeIdentificationRepository $typeIdentificationRepository, TypeOfThirdRepository $typeOfThirdRepository, TypeRegimeIvaRepository $typeRegimeIvaRepository, UserRepository $userRepository, FiscalResponsabilityThirdRepository $fiscalResponsabilityThirdRepository, ContactThirdRepository $contactThirdRepository, PhoneThirdRepository $phoneThirdRepository,DepartamentsRepository $departamentsRepository,CityRepository $cityRepository)
    {
        $this->thirdRepository = $thirdRepository;
        $this->basicDataTypeRepository = $basicDataTypeRepository;
        $this->fiscalResponsabilityRepository = $fiscalResponsabilityRepository;
        $this->typeIdentificationRepository = $typeIdentificationRepository;
        $this->typeOfThirdRepository = $typeOfThirdRepository;
        $this->typeRegimeIvaRepository = $typeRegimeIvaRepository;
        $this->userRepository = $userRepository;
        $this->fiscalResponsabilityThirdRepository = $fiscalResponsabilityThirdRepository;
        $this->contactThirdRepository = $contactThirdRepository;
        $this->phoneThirdRepository = $phoneThirdRepository;
        $this->departamentsRepository = $departamentsRepository; 
        $this->cityRepository = $cityRepository; 
    }

    public function list(Request $request)
    {
        $data =  $this->thirdRepository->list($request->all(), ['typeIdentificaction', 'TypeRegimenIva']);
        $thirds = ThirdListResource::collection($data);

        return [
            'thirds' => $thirds,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(ThirdRequest $request)
    {
        try {
            DB::beginTransaction();
            $arrayPhone = $request['arrayPhone'];
            $arrayContact = $request['arrayContact'];
            $arrayFiscalResponsability = $request['arrayFiscalResponsability'];
            $arrayTypeThird = $request['arrayTypeThird'];
            unset($request['arrayPhone']);
            unset($request['phones_thirds']);
            unset($request['arrayContact']);
            unset($request['contacts_thirds']);
            unset($request['arrayFiscalResponsability']);
            unset($request['fiscal_responsability_thirds']);
            unset($request['arrayTypeThird']);
            unset($request['types_thirds']);
            $data = $this->thirdRepository->store($request->all());
            if (count($arrayPhone) > 0) {
                foreach ($arrayPhone as $key => $value) {
                    if (isset($value['delete'])) {
                        $this->phoneThirdRepository->delete($value['id']);
                    } else {
                        unset($value['delete']);
                        $value['third_id'] = $data->id;
                        $value['company_id'] = $request['company_id'];
                        $this->phoneThirdRepository->store($value);
                    }
                }
            }
            if (count($arrayContact) > 0) {
                foreach ($arrayContact as $key => $value) {
                    if (isset($value['delete'])) {
                        $this->contactThirdRepository->delete($value['id']);
                    } else {
                        unset($value['delete']);
                        $value['third_id'] = $data->id;
                        $value['company_id'] = $request['company_id'];
                        $this->contactThirdRepository->store($value);
                    }
                }
            }
            if (count($arrayFiscalResponsability) > 0) {
                $data->fiscalResponsabilityThirds()->sync($arrayFiscalResponsability);
            }
            if (count($arrayTypeThird) > 0) {
                $data->typesThirds()->sync($arrayTypeThird);
            }
            DB::commit();

            $msg = "agregado";
            if (!empty($request["id"])) $msg = "modificado";

            return response()->json(["code" => 200, "message" => "Registro " . $msg . " correctamente", "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
        return $this->thirdRepository->store($request);
    }

    public function info($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->thirdRepository->find($id, ['fiscalResponsabilityThirds:id', 'phonesThirds', 'contactsThirds','typesThirds']);
            DB::commit();
            return response()->json(["code" => 200, "data" => $data]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function dataForm(Request $request)
    {
        $request['typeData'] = 'todos';
        $basicDataType = $this->basicDataTypeRepository->all();
        $fiscalResponsability = $this->fiscalResponsabilityRepository->all();
        $typeIdentification = $this->typeIdentificationRepository->all();
        $typeOfThird = $this->typeOfThirdRepository->all();
        $typeRegimeIva = $this->typeRegimeIvaRepository->all();
        $departaments = $this->departamentsRepository->all();

        $request['typeData'] = 'todos';
        $request['state'] = 1;
        $userCompany = $this->userRepository->list($request->all());
        return response()->json([
            'basicDataType' => $basicDataType,
            'fiscalResponsability' => $fiscalResponsability,
            'typeIdentification' => $typeIdentification,
            'typeOfThird' => $typeOfThird,
            'typeRegimeIva' => $typeRegimeIva,
            'userCompany' => $userCompany,
            'departaments' => $departaments,
        ]);
    }

    public function changeState(Request $request)
    {
        try {
            DB::beginTransaction();

            $model = $this->thirdRepository->changeState($request->input('id'), $request->input('state'), 'state');

            ($model->in_use == 1) ? $msg = 'Activado' : $msg = 'Inactivado';

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Tercero ' . $msg . ' con éxito']);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }

    public function excel(Request $request)
    {
        try {
            unset($request['typeData']);
            $data =  $this->thirdRepository->list($request->all(), ['typeIdentificaction', 'TypeRegimenIva']); 
            $fileName = 'thirds.xlsx';
            $path = $request->root() . '/storage/' . $fileName;
            $excel = Excel::store(new ThirdExport($data), $fileName, 'public');
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
            $data = $this->thirdRepository->find($id);
            if($data){
                $data->phonesThirds()->delete();
                $data->contactsThirds()->delete();
                $data->delete();
                $msg = 'Registro eliminado correctamente';
            }else $msg = 'El registro no existe';
            DB::commit();
            return response()->json(["code" => 200, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function select2InfiniteList(Request $request)
    {
        $data =  $this->thirdRepository->list($request->all());
        $customers = ThirdSelect2Resource::collection($data);
        return [
            'customers_arrayInfo' => $customers,
            'customers_countLinks' => $data->lastPage(),
        ];
    }
}
