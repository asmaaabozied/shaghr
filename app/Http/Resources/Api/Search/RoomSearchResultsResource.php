<?php

namespace App\Http\Resources\Api\Search;

use App\Http\Resources\Api\Amenities\AmenitiesResource;
use App\Http\Resources\Api\Rooms\ReviewResource;
use App\Http\Resources\Api\Rooms\RoomTypeResource;
use App\Http\Resources\RoomPrices;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomSearchResultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [

        ];
    }
}
