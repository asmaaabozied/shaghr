<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenityRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the range of room IDs and amenity IDs
        $rooms = range(1, 20); // Assuming room IDs range from 1 to 20
        $amenities = range(1, 10); // Assuming amenity IDs range from 1 to 10

        // Loop through each room
        foreach ($rooms as $roomId) {
            // Shuffle and pick at least 6 random amenities for the room
            $randomAmenities = collect($amenities)->shuffle()->take(rand(6, count($amenities)));

            foreach ($randomAmenities as $amenityId) {
                // Check for duplicates
                $exists = DB::table('amenity_rooms')
                    ->where('room_id', $roomId)
                    ->where('amenity_id', $amenityId)
                    ->exists();

                if (!$exists) {
                    DB::table('amenity_rooms')->insert([
                        'room_id' => $roomId,
                        'amenity_id' => $amenityId,
                    ]);
                }
            }
        }
    }
}
