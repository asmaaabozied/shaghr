<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailablitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 availabilities
        for ($i = 1; $i <= 10; $i++) {
             $availabity= DB::table('availabilities')->updateOrInsert(
                    [

                        'date' => Carbon::now(),
                        'type'=>'available',
                        'room_id'=>$i,
                        'hotel_id'=>$i,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]
                );



        }
    }

    }
