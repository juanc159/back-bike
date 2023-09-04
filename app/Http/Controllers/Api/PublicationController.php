<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Publication\PublicationStoreRequest;
use App\Http\Resources\PublicationInfoResource;
use App\Http\Resources\PublicationListDataResource;
use App\Http\Resources\PublicationListResource;
use App\Repositories\PublicationFileRepository;
use App\Repositories\PublicationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PublicationController extends Controller
{
    private $publicationRepository;
    private $publicationFileRepository;

    public function __construct(PublicationRepository $publicationRepository, PublicationFileRepository $publicationFileRepository)
    {
        $this->publicationRepository = $publicationRepository;
        $this->publicationFileRepository = $publicationFileRepository;
    }

    public function listData(Request $request)
    {
        $data = $this->publicationRepository->list(["typeData" => "all","status" =>1]);
        $publications = PublicationListDataResource::collection($data);
        return [
            'publications' => $publications, 
        ];
    }
    public function viewDetail($id)
    {
        $data = $this->publicationRepository->find($id);
        $publication = new PublicationListDataResource($data);
        return [
            'publication' => $publication, 
        ];
    }
    public function list(Request $request)
    {
        $data = $this->publicationRepository->list($request->all());
        $publications = PublicationListResource::collection($data);
        return [
            'publications' => $publications,
            'lastPage' => $data->lastPage(),
            'totalData' => $data->total(),
            'totalPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
        ];
    }

    public function store(PublicationStoreRequest $request)
    {
        foreach ($request->all() as $key => $value) {
            $data[$key] = $request[$key] != 'null' ? $request[$key] : null;
        }
        $post = $data;
        for ($i = 0; $i < $request['countFiles']; $i++) {
            unset($post['file' . $i]);
            unset($post['file_id' . $i]);
            unset($post['file_name' . $i]);
            unset($post['file_order' . $i]);
            unset($post['file_delete' . $i]);
        }
        unset($post['countFiles']);
        try {
            DB::beginTransaction();
            $data = $this->publicationRepository->store($post); 
            for ($i = 0; $i < $request['countFiles']; $i++) {
                $info = [];
                if ($request->input('file_delete' . $i) == 'delete') {
                    $this->publicationFileRepository->delete($request->input('file_id' . $i));
                } else {
                    if ($request->file('file' . $i)) {
                        $file = $request->file('file' . $i);
                        $path = $request->root() . '/storage/' . $file->store('/Publications/Publication_' . $data->id . $request->input('file' . $i), 'public');
                        $info['path'] = $path;
                        $info['order'] = $request->input('file_order' . $i);
                        $info['publication_id'] = $data->id;
                        $this->publicationFileRepository->store($info);
                    }
                }
            }

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
            $data = $this->publicationRepository->find($id);
            if ($data) {
                $data->files()->delete();
                $data->delete();
                $msg = "Registro eliminado correctamente";
            } else $msg = "El registro no existe";
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
            $data = $this->publicationRepository->find($id);
            if ($data) {
                $data = new PublicationInfoResource($data);

                $msg = "Registro encontrado con éxito";
            } else $msg = "El registro no existe";
            DB::commit();
            return response()->json(["code" => 200, "data" => $data, "message" => $msg]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(["code" => 500, "message" => $th->getMessage()], 500);
        }
    }

    public function changeState(Request $request)
    {
        try {
            DB::beginTransaction(); 

            $model = $this->publicationRepository->changeState($request->input('id'), $request->input('status'), 'status');
            ($model->status == 1) ? $msg = 'Activado' : $msg = 'Inactivado';

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Usuario '.$msg.' con éxito']);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }
}
