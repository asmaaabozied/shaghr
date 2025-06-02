<?php

namespace App\Http\Resources\Api\Images;

use App\Http\Resources\Api\Amenities\AmenitiesTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageGalleryResource extends JsonResource
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
            'title' => $this->title,
            'image_name' => $this->image_name,
            'status' => $this->status,
            'published' => $this->published,
            'size' => $this->size,
            'extension' => $this->extension,
            'thumbnail'=>$this->thumbnail ?? null,
            'alternative_text'=>$this->alternative_text ?? null,
            'image' => $this->image ? asset('images/images/' . $this->image) : null, // Include the image path if available
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
