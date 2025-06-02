<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 hotels with unique names
        for ($i = 1; $i <= 20; $i++) {
            DB::table('hotels')->updateOrInsert(
                ['name_en' => 'Hotel ' . $i],  // Unique condition (name_en is used as a unique identifier)
                [
                    'chain_id' => rand(1, 3),  // Random chain ID (e.g., 1 to 3)
                    'name_en' => 'Hotel ' . $i,
                    'name_ar' => 'فندق ' . $i,
                    'total_rooms' => rand(50, 150),  // Random number of rooms between 50 and 150
                    'image' => 'images/hotels/hotel' . $i . '.jpg',
                    'phone' => '+123456789' . rand(0, 9),
                    'email' => 'info@hotel' . $i . '.com',
                    'address' => 'Street ' . $i . ', City ' . rand(1, 10),
                    'descripton_en' => 'This is Hotel ' . $i . ' providing excellent service.',
                    'descripton_ar' => 'هذا هو فندق ' . $i . ' يقدم خدمة ممتازة.',
                    'rating' => rand(1, 5) / 2,  // Random rating between 0.5 and 5
                    'country_id' => 196,  // Random country ID (just an example)
                    'city_id' => rand(1, 50),    // Random city ID (just an example)
                    'district_id' => rand(1, 50), // Random district ID
                    'street' => 'Street ' . $i,
                    'building_number' => (string)rand(1, 100),
                    'status' => 1,
                    'hotel_policy_en' => 'hotel_policy description ' . $i . '-' . ' in English',
                    'hotel_policy_ar' => 'وصف سياسة الفندق ' . $i . '-' .' بالعربية',
                    'creator_id' =>1,  // Random creator ID (just an example)
                    'update_id' => 1,   // Random updater ID
                    'delete_id' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ]
            );
        }
    }
}
