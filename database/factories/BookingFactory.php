<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Hotels\Hotels;
use App\Models\Rooms\Room;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_time = $this->faker->dateTimeBetween('+1 day', '+30 days');
        $duration = $this->faker->randomElement([3, 6, 9, 12]);
        $end_time = Carbon::parse($start_time)->addHours($duration);
        $user_id = User::inRandomOrder()->value('id');
        $room_id = Room::inRandomOrder()->value('id');
        $hotel_id = Hotels::inRandomOrder()->value('id');
        return [
            'user_id' => $user_id, // Assumes a UserFactory exists
            'room_id' => $room_id, // Assumes a RoomFactory exists
            'hotel_id' => $hotel_id, // Assumes a RoomFactory exists
            'start_time' => $start_time,
            'end_time' => $end_time,
            'duration' => $duration,
            'status' => $this->faker->randomElement(BookingStatus::cases())->value, // Random status
        ];
    }
}
