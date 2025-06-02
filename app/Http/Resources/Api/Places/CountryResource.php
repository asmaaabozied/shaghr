<?php

namespace App\Http\Resources\Api\Places;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'name' => $this->name,
            'code' => $this->code,
            'icon' => $this->icon ? asset('images/countries/' . $this->icon) : null, // Include the icon path if available

        ];
    }
}
