<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function new($data = [])
    {
        return new $this->model($data);
    } 
    public function newModelInstance()
    {
        return $this->model::newModelInstance();
    } 

    public function all()
    {
        return $this->model->all();
    }

    public function first()
    {
        return $this->model->first();
    }

    public function get($with = [])
    {
        return $this->model->with($with)->get();
    }

    public function find($id, $with = [], $select = '*',$withCount=[])
    {
        return $this->model->select($select)->withCount($withCount)->with($with)->find($id);
    }

    public function save(Model $model)
    {
        $model->save();

        return $model;
    }
    public function make(Model $model)//esto es para simular un registro
    {
        $model->make();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        $model->delete();

        return $model;
    }

    public function changeState($id, $estado, $column = 'estado', $with = [])
    {
        $model = $this->model->with($with)->find($id);
        $model[$column] = $estado;
        $model->save();

        return $model;
    }

    public function pdf($vista, $data = [], $nombre = 'archivo', $is_stream = true, $landspace = false)
    {
        $pdf = \PDF::loadview($vista, compact('data'));
        // dd($landspace);
        if ($landspace == true) {
            // dd('llego');
            $pdf->setPaper('legal', 'landscape');
        }
        // dd('pasí');

        $nombre = $nombre.'.pdf';
        if ($is_stream) {
            return $pdf->stream($nombre);
        } else {
            return $pdf->download($nombre);
        }
    }

    public function datos_activos($key = 'estado', $value = '1')
    {
        return $this->model->where($key, $value)->get();
    }

}
