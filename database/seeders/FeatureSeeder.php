<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 features
        for ($i = 1; $i <= 10; $i++) {
              DB::table('features')->updateOrInsert(
                    [
                        'name_ar' => 'سمات ' . $i,
                        'name_en' => 'features ' . $i,
                        'status' => 1,
                        'description_ar' => 'وصف سمات ' . $i . '-' . ' بالعربية',
                        'description_en' => 'features description ' . $i . '-' .  ' in English',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );





        }
    }

    }
