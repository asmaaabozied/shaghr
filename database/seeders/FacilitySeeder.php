<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 features
        for ($i = 1; $i <= 10; $i++) {
              DB::table('facilities')->updateOrInsert(
                    [
                        'name_ar' => 'مرافق ' . $i,
                        'name_en' => 'Facility ' . $i,
                        'active' => 1,
                        'description_ar' => 'وصف مرافق ' . $i . '-' . ' بالعربية',
                        'description_en' => 'Facilities description ' . $i . '-' .  ' in English',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );





        }
    }

    }
