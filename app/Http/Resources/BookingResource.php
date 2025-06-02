<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'room_id' => $this->room_id,
            'hotel_id' => $this->hotel_id,
            'check_in_date' => $this->check_in_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'time_slot' => $this->time_slot,
            'price' => $this->price,
            'number_people' => $this->number_people,
            'room_type_id' => $this->room_type_id,
            'status' => $this->status,
        ];
    }
}
