<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\TypesQuote;
use Throwable;

class TypesQuoteRepository extends BaseRepository
{
    protected $typesQuoteFileRepository;

    public function __construct(TypesQuote $modelo, TypesQuoteFileRepository $typesQuoteFileRepository)
    {
        parent::__construct($modelo);
        $this->typesQuoteFileRepository = $typesQuoteFileRepository;
    }

    public function list($request = [], $with = [], $select = ["*"], $withCount = [])
    {
        $data = $this->model->select($select)->withCount($withCount)->with($with)->where(function ($query) use ($request) {
            if (!empty($request["company_id"])) {
                $query->where("company_id", $request["company_id"]);
            }
            if (!empty($request["inUse"])) {
                $query->where("inUse", $request["inUse"]);
            }
        })
            ->where(function ($query) use ($request) {
                if (!empty($request['searchQuery'])) {
                    $query->orWhere('voucherCode', 'like', '%' . $request['searchQuery'] . '%');
                    $query->orWhere('voucherName', 'like', '%' . $request['searchQuery'] . '%');
                }
            });

        if (empty($request['typeData'])) {
            $data = $data->paginate($request["perPage"] ?? 10);
        } else {
            $data = $data->get();
        }
        return $data;
    }

    public function store($request)
    {
        $post = $request->all(); 
        unset($post['files']);
        for ($i=0; $i < $request->input("cantArrayArchivesEmail"); $i++) {
            unset($post['emailFile'.$i]);
            unset($post['emailFile_delete'.$i]);
            unset($post['emailFile_id'.$i]);
            unset($post['emailFile_name'.$i]);
        }
        unset($post['cantArrayArchivesEmail']);

        if (!empty($request["id"]) && $request["id"] != "null") $data = $this->model->find($request["id"]);
        else $data = $this->model::newModelInstance();

        foreach ($post as $key => $value) {
            $data[$key] = $post[$key] != "null" ? $post[$key] : null;
        }
        $data->save();

        for ($i = 0; $i < $request->input("cantArrayArchivesEmail"); $i++) {
            if ($request->input("emailFile_id" . $i) != 'null' && $request->input("emailFile_delete" . $i) != 'undefined' && $request->input("emailFile_delete" . $i) != '0') {
                $image = $this->typesQuoteFileRepository->find($request->input("emailFile_id" . $i));
                $image->delete();
            }
            if ($request->file("emailFile" . $i)) {
                $file = $request->file("emailFile" . $i);
                $path = $request->root() . "/storage/" . $file->store('/companies/company_' . $data->company_id . '/typesQuotes/typesQuote_' . $data->id . '/' . $request->input("emailFile" . $i), "public");
                $dataImage["typesQuote_id"] =  $data->id;
                $dataImage["path"] = $path;
                $dataImage["name"] = $request->input("emailFile_name" . $i);
                $this->typesQuoteFileRepository->store($dataImage);
            }
        }

        return $data;
    }

    public function typesQuoteDelete($id)
    {
        try {
            $data = $this->model->find($id);
            if (!empty($data->detailInvoiceAvailable) && count($data->detailInvoiceAvailable) > 0)
                $data->detailInvoiceAvailable()->delete();
            if (!empty($data->files) && count($data->files) > 0)
                $data->files()->delete();
            $data->delete();
        } catch (Throwable $th) {
            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }

    public function validateNumber($request)
    {
        $value = false;
        $data = $this->model->where(function ($query) use ($request) {
            if (!empty($request["typesReceiptInvoice_id"])) {
                $query->where("id", $request["typesReceiptInvoice_id"]);
            }
            if (!empty($request["company_id"])) {
                $query->where("company_id", $request["company_id"]);
            }
        })->first();

        if ($data) {
            $invoice = Invoice::where('typesReceiptInvoice_id', $request["typesReceiptInvoice_id"])->where('company_id', $request["company_id"])->get();
            $total = number_format($data->initialNumbering) + count($invoice);
            $numberFinal = number_format($data->finalNumbering);
            if ($total > $numberFinal) $value = true;
        }

        return $value;
    }
}
