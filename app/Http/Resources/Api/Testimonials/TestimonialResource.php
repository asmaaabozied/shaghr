<?php

namespace App\Http\Resources\Api\Testimonials;

use App\Http\Resources\Api\Amenities\AmenitiesTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'submission_date' => $this->submission_date,
            'name' => $this->name,
            'position' => $this->position,
            'rating' => $this->rating,
            'status' => $this->Status,
            'active' => $this->active,
            'Published' => $this->Published,
            'review_text' => $this->review_text,
            'user'=>$this->user->name ?? null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
