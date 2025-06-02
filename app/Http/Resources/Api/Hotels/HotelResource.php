<?php

namespace App\Http\Resources\Api\Hotels;

use App\Http\Resources\Api\Chains\ChainResource;
use App\Http\Resources\Api\Places\CitiesResource;
use App\Http\Resources\Api\Places\CountryResource;
use App\Http\Resources\Api\Places\DistrictsResource;
use App\Http\Resources\Api\Rooms\RoomResource;
use App\Models\Hotels\HotelUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class HotelResource extends JsonResource
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
           'descripton'=> $this->descripton_en ? $this->descripton  : null,
           'hotel_policy' => $this->hotel_policy_en ? $this->hotel_policy_en  : null, // Include the hotel_policy
           'price'=>$this->rooms->first()->pricing ?? 0, 
           'active' => $this->status,
            'total_rooms' => $this->total_rooms,
            "count_rooms" => count($this->rooms) ?? 0,
            'rating' => $this->rating ?? 0,
            'phone' => $this->phone,
            'email' => $this->email,
            "favorite" => (count(HotelUser::where('hotel_id','=',$this->id)->where('user_id','=',Auth::id())->get())>0 ? true : false),
            'address' => $this->address,
            'street' => $this->street,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'building_number' => $this->building_number,
            'image' => $this->image ? asset('images/hotels/' . $this->image) : asset('images/hotels/default.jpeg'), // Include the image path if available
            'document' => $this->document ? asset('images/hotels/' . $this->document) : asset('images/hotels/default.jpeg'), // Include the image path if available
            'images'=>$this->images,
            'country' => new CountryResource($this->country),
            'city' => new CitiesResource($this->city),
            'district' => new DistrictsResource($this->district),
//            'address' => [
//                'country' => new CountryResource($this->whenLoaded('country')),
//                'city' => new CitiesResource($this->whenLoaded('city')),
//                'district' => new DistrictsResource($this->whenLoaded('district')),
//                'street' => $this->street,
//                'building_number' => $this->building_number,
//            ],
            'chain' => new ChainResource($this->chain),
            'rooms' => RoomResource::collection($this->rooms),
            'creator' => $this->creator,
            'update_id' => $this->update_id,
            'delete_id' => $this->delete_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
