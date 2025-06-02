<?php

namespace App\Http\Resources\Api\Rooms;

use App\Http\Resources\Api\Amenities\AmenitiesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Rooms\RoomUser;
class RoomResource extends JsonResource
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
            'title'=> $this->title_en ? $this->title  : null,
            'description'=> $this->description_en ? $this->description  : null,
            'space' => $this->space,
            'number_people' => $this->number_people,
            "rate_comment" => round($this->comments->avg('rating')) ?? 0,
            "count_comment" => count($this->comments) ?? 0,
            "review_rate" => round($this->reviews->avg('rating')) ?? 0,
            "count_review" => count($this->reviews) ?? 0,
            "favorite" => (count(RoomUser::where('room_id','=',$this->id)->where('user_id','=',Auth::id())->get())>0 ? true : false),
            'status' => $this->status,
            'hotel_id' => $this->hotel_id,
            'active' => $this->active,
            'pricing' => $this->pricing,
            'hotel_policy' => $this->hotel ? $this->hotel->hotel_policy_en  : null, // Include the hotel_policy
            'prices'=>$this->prices,
            'images'=>$this->images,
            'room_type' => new RoomTypeResource($this->whenLoaded('roomType')),
            'amenities'=>AmenitiesResource::collection($this->amenities),
            'availabilities'=>AvailabilityResource::collection($this->availabilities),
            'comments'=>CommentResource::collection($this->comments),
            'reviews'=>ReviewResource::collection($this->reviews),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
