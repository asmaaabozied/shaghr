<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

class CreateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'hotel_id' => 'required|exists:hotels,id',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s|after:start_time',
            'time_slot' => 'required|integer|in:3,6,9,12',
            'price' => 'required|integer|min:0',
            'number_people' => 'nullable|integer|min:1',
            'room_type_id' => 'required|exists:room_types,id',
            'status' => 'in:pending,confirmed,cancelled'
        ];
    }

    /**
     * Configure the validator instance.
     */
//    public function withValidator(Validator $validator): void
//    {
//        $validator->after(function ($validator) {
//            if ($this->hasConflictingBooking()) {
//                $validator->errors()->add('start_time', 'Room is not available for the selected time slot.');
//            }
//        });
//    }

    /**
     * Check if there's a conflicting Booking for the given room and time slot.
     */
//    protected function hasConflictingBooking(): bool
//    {
//        $start_time = Carbon::parse($this->input('start_time'));
//        $end_time = $start_time->copy()->addHours($this->input('duration'));
//
//        return Booking::where('room_id', $this->input('room_id'))
//            ->where(function ($query) use ($start_time, $end_time) {
//                $query->whereBetween('start_time', [$start_time, $end_time])
//                    ->orWhereBetween('end_time', [$start_time, $end_time])
//                    ->orWhere(function ($q) use ($start_time, $end_time) {
//                        $q->where('start_time', '<', $start_time)
//                            ->where('end_time', '>', $end_time);
//                    });
//            })
//            ->exists();
//    }
}
