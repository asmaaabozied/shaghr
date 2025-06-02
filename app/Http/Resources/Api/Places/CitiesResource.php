<?php

namespace App\Http\Resources\Api\Places;
use Illuminate\Http\Resources\Json\JsonResource;

class CitiesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'name' => $this->name,
            'image' => $this->image ? asset('images/cities/' . $this->image) : null, // Include the image path if available
            'country' => new CountryResource($this->whenLoaded('country')),  // Include country details if loaded
        ];
    }
}
