<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $indice = strpos($this->name,'_');
        $name = substr($this->name, 0, $indice);
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'name' => $name,
            'guard_name' => $this->guard_name,
            'description' => $this->description,
            'company_name' => $this->company?->name,
        ];
    }
}
