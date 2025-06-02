<?php

namespace App\Http\Resources\Api\Rooms;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FacilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name'=> $this->name_en ? $this->name  : null,
            'description'=> $this->description_en ? $this->description  : null,
            'active' => $this->active,
            'image' => $this->image ? asset('images/facilities/' . $this->image) : null, // Include the image path if available
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d '),
        ];
    }
}
