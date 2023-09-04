<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationListDataResource extends JsonResource
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
            // "barter" => $this->barter == 1 ? "Si" : "No", 
            "price" => $this->price, 
            // "offer" => $this->offer, 
            // "days" => $this->days, 
            "status" => $this->status, 
            "files" => $this->files->map(function($value){
                return [
                    "id" => $value->id,
                    "path" => $value->path,
                    "order" => $value->order,
                ];
            }), 
        ];
    }
}
