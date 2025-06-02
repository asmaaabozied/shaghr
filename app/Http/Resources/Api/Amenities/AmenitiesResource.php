<?php

namespace App\Http\Resources\Api\Amenities;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmenitiesResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'type' =>new AmenitiesTypeResource($this->type),
            'status' => $this->status,
            'icon' => $this->icon ? asset('images/amenities/' . $this->icon) : null, // Include the image path if available
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
