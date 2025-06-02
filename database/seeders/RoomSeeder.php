<?php

namespace Database\Seeders;

use App\Models\Rooms\RoomComment;
use App\Models\Rooms\RoomPrice;
use App\Models\Rooms\RoomReview;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 rooms for each hotel
        for ($i = 1; $i <= 10; $i++) {
            // Create 2 rooms per hotel for simplicity
            for ($j = 1; $j <= 2; $j++) {
               $room=DB::table('rooms')->updateOrInsert(
                    [
                        'name_en' => 'Room ' . $i . '-' . $j,  // Unique condition (room names are unique)
                        'hotel_id' => $i  // Ensure the room is linked to an existing hotel (hotel_id exists in hotels table)
                    ],
                    [
                        'name_ar' => 'غرفة ' . $i . '-' . $j,
                        'name_en' => 'Room ' . $i . '-' . $j,
                        'title_en' => 'Room ' . $i . '-' . $j . ' Title in English',
                        'title_ar' => 'عنوان الغرفة ' . $i . '-' . $j . ' بالعربية',
                        'space' => rand(20, 50) . ' m²',  // Random room size between 20 and 50 square meters
                        'number_people' => rand(1, 20), // Random room number_people between 1 and 20
                        'pricing' => rand(100, 300) . ' USD',  // Random price between 100 and 300
                        'status' => 1,
                        'active' => 1,
                        'description_ar' => 'وصف الغرفة ' . $i . '-' . $j . ' بالعربية',
                        'description_en' => 'Room description ' . $i . '-' . $j . ' in English',
                        'room_type_id'=>rand(1,3),
                        'hotel_id' => $i,  // Link to the hotel
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );


            }

           RoomComment::create([
               'room_id'=>$i,
               'rating' => rand(1, 5),
               'view'=>1,
               'description_ar' => 'وصف الغرفة ' . $i . '-' . $j . ' بالعربية',
               'description_en' => 'Room description ' . $i . '-' . $j . ' in English',
               'user_id'=>rand(1,5)
           ]);
            RoomReview::create([
               'room_id'=>$i,
               'rating' => rand(1, 5),
               'view'=>1,
               'description_ar' => 'وصف الغرفة ' . $i . '-' . $j . ' بالعربية',
               'description_en' => 'Room description ' . $i . '-' . $j . ' in English',
               'user_id'=>rand(1,5)
           ]);
            RoomPrice::create([
               'room_id'=>$i,
               'time_slot' => rand(1, 4),
                'price' => rand(100, 300),
           ]);

        }
    }

    }
