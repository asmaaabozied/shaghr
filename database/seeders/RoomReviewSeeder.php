<?php

namespace Database\Seeders;

use App\Models\Rooms\Room;
use App\Models\Rooms\RoomReview;
use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RoomReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assuming Room and User models already have data
        $roomIds = Room::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // Generate 50 random room reviews
        foreach (range(1, 50) as $index) {
            RoomReview::create([
                'rating' => $faker->numberBetween(1, 5), // Random rating from 1 to 5
                'room_id' => $faker->randomElement($roomIds), // Random room ID
                'user_id' => $faker->randomElement($userIds), // Random user ID
                'view' => $faker->numberBetween(0, 1000), // Random view count
                'status' => $faker->boolean(80), // 80% chance of being true
                'description_ar' => $faker->sentence(10), // Random Arabic description
                'description_en' => $faker->sentence(10), // Random English description
                'created_by' => $faker->randomElement($userIds), // Random created by user
                'updated_by' => $faker->randomElement($userIds), // Random updated by user
            ]);
        }
    }
}
