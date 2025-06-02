<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 amenities
        for ($i = 1; $i <= 10; $i++) {
               DB::table('amenities')->updateOrInsert([
                        'name_ar' => 'خدمه  ' . $i,
                        'name_en' => 'Service ' . $i,
                        'status' => 1,
                        'description_ar' => 'وصف الخدمه  ' . $i . '-' .  ' بالعربية',
                        'description_en' => 'Services description ' . $i . '-' . ' in English',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );





        }
    }

    }
