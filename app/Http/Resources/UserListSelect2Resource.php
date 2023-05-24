<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListSelect2Resource extends JsonResource
{ 
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $indice = strpos($this->role?->name,'_');
        $name = substr($this->role?->name, 0, $indice);
        return [
            'id' => $this->id, 
            'name' => $this->name,
        ];
    }
}
