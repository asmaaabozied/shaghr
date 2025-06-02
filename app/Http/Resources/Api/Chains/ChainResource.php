<?php

namespace App\Http\Resources\Api\Chains;

use App\Http\Resources\Api\User\AuthResource;
use App\Http\Resources\Api\User\UserItem;
use App\Http\Resources\Api\User\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChainResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'name' => $this->name,
            'user' => new UserItem($this->user ),
            'hotels_count' => $this->hotels_count,
            "total" => count($this->hotels) ?? 0,
            'active'=>$this->active,
            'document'=>$this->document,
            'image' => $this->image ? asset('images/chains/' . $this->image) : asset('images/chains/default.jpeg'), // Include the image path if available
            'created_at' =>$this->created_at
        ];
    }
}
