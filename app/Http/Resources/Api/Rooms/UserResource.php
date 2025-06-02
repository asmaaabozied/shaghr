<?php

namespace App\Http\Resources\Api\Rooms;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'image'      => $this->image ? asset('storage/' . $this->image) : null, // Include the image path if available
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
