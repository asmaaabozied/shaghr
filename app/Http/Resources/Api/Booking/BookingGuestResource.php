<?php

namespace App\Http\Resources\Api\Booking;

use App\Http\Resources\Api\Hotels\HotelResource;
use App\Http\Resources\Api\Rooms\RoomResource;
use App\Http\Resources\Api\User\UserProfile;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingGuestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'time_slot' => $this->time_slot,
            'price' => $this->price,
            'number_people' => $this->number_people,
            'status' => $this->status,
            'hotel_id' => $this->hotel_id,
            'payment' => 'card',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => new UserProfile($this->user),
            'room' => new RoomResource($this->room)

        ];
    }
}
