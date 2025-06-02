<?php

namespace App\Http\Resources\Api\Search;

use App\Http\Resources\Api\Amenities\AmenitiesResource;
use App\Http\Resources\Api\Chains\ChainResource;
use App\Http\Resources\Api\Places\CitiesResource;
use App\Http\Resources\Api\Places\CountryResource;
use App\Http\Resources\Api\Places\DistrictsResource;
use App\Http\Resources\Api\Rooms\AvailabilityResource;
use App\Http\Resources\Api\Rooms\RoomResource;
use App\Http\Resources\Api\Rooms\RoomTypeResource;
use App\Http\Resources\RoomPrices;
use App\Models\Hotels\HotelUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SearchResultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     *
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'number_of_people'=>$this->number_of_people,
            'name'=> $this->hotel->name  ,
            'image' => $this->hotel->image ? asset('images/hotels/' . $this->image) : asset('images/hotels/default.jpeg'), // Include the image path if available
            'document' => $this->hotel->document ? asset('images/hotels/' . $this->document) : asset('images/hotels/default.jpeg'), // Include the image path if available
            'images'=>$this->hotel->images,
            'city' =>  $this->hotel->city->name??null,
//              "rooms"=>  RoomSearchResultsResource::collection($this->rooms)


            'room_type' =>  RoomTypeResource::make($this->whenLoaded('roomType')),
            'review_rate' => round($this->reviews->avg('rating')) ?? 0,
            'prices' =>  RoomPrices::collection($this->whenLoaded('prices')),
            'amenities'=> AmenitiesResource::collection($this->amenities),
            'availabilities'=> AvailabilityResource::collection($this->whenLoaded('availabilities')),
        ];
    }
}
