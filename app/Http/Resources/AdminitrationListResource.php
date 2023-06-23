<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminitrationListResource extends JsonResource
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
            "cost" => $this->cost,
            "init_date" => Carbon::parse($this->init_date)->format('Y-m-d'),
            "final_date" => Carbon::parse($this->final_date)->format('Y-m-d'),
            "status" => $this->status
        ];
    }
}
