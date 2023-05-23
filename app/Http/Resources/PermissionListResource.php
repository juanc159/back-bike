<?php

namespace App\Http\Resources;

use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionListResource extends JsonResource
{ 
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        $menu = $this->menu_id ? Menu::find($this->menu_id) : "";
        return [
            'id' => $this->id,
            'group' => $menu ? $menu->title : "",
            'name' => $this->name,
            'description' => $this->description, 
        ];
    }
}
