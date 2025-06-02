<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 amenities_types
        for ($i = 1; $i <= 10; $i++) {
               DB::table('amenities_types')->updateOrInsert([
                        'name_ar' => 'خدمه  ' . $i,
                        'name_en' => 'Service ' . $i,
                        'status' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );





        }
    }

    }
