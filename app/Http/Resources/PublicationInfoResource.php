<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationInfoResource extends JsonResource
{ 
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name, 
            "description" => $this->description, 
            "barter" => $this->barter, 
            "price" => $this->price, 
            "offer" => $this->offer, 
            "days" => $this->days, 
            "model" => $this->model, 
            "year" => $this->year, 
            "files" => $this->files->map(function($value){
                return [
                    "id" => $value->id,
                    "order" => $value->order,
                    "path" => $value->path,
                ];
            }), 
        ];
    }
}
