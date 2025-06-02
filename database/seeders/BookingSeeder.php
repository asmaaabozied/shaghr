<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotels\Hotels;
use App\Models\Rooms\Room;
use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch available room and user IDs
        $roomIds = Room::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();
        $hotelIds = Hotels::pluck('id')->toArray();

        // Define time slot prices
        $timeSlotPrices = [
            3 => 50,
            6 => 100,
            9 => 300,
            12 => 600,
        ];

        // Generate 20 random bookings
        foreach (range(1, 20) as $index) {
            $roomId = $faker->randomElement($roomIds);
            $userId = $faker->randomElement($userIds);
            $hotelId = $faker->randomElement($hotelIds);
            $timeSlot = $faker->randomElement(array_keys($timeSlotPrices));

            // Generate a random start time (avoiding past times)
            $startTime = Carbon::now()->addDays($faker->numberBetween(1, 30))->setHour($faker->numberBetween(8, 20));
            $endTime = (clone $startTime)->addHours($timeSlot);

            // Ensure no conflicting bookings exist
            $conflictExists = Booking::where('room_id', $roomId)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function ($query) use ($startTime, $endTime) {
                            $query->where('start_time', '<', $startTime)
                                ->where('end_time', '>', $endTime);
                        });
                })->exists();

            if (!$conflictExists) {
                Booking::create([
                    'user_id' => $userId,
                    'room_id' => $roomId,
                    'hotel_id' => $hotelId,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'time_slot' => $timeSlot,
                    'price' => $timeSlotPrices[$timeSlot],
                    'number_people' => rand(1, 5),
                    'room_type_id' => rand(1, 3),
                    'status' => $faker->randomElement(['pending', 'confirmed']),
                ]);
            }
        }

        $this->command->info('20 bookings have been created successfully.');
    }
}
