<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Predefined time slots with their respective prices
        $timeSlotPrices = [
            3 => 50,
            6 => 100,
            9 => 300,
            12 => 600,
        ];

        // Insert 20 random entries
        for ($i = 0; $i < 20; $i++) {
            $timeSlot = array_rand($timeSlotPrices); // Random time slot
            $price = $timeSlotPrices[$timeSlot]; // Get the fixed price for the time slot
            $roomId = rand(1, 20); // Random room_id between 1 and 20

            // Check if the record already exists
            $exists = DB::table('room_prices')
                ->where('time_slot', $timeSlot)
                ->where('room_id', $roomId)
                ->exists();

            if (!$exists) {
                DB::table('room_prices')->insert([
                    'time_slot' => $timeSlot,
                    'price' => $price,
                    'room_id' => $roomId,
                ]);
            }
        }
    }
}
