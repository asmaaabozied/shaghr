<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 services
        for ($i = 1; $i <= 10; $i++) {
               DB::table('services')->updateOrInsert(
                    [
                        'name_ar' => 'خدمة ' . $i,
                        'name_en' => 'service ' . $i,
                        'active' => 1,
                        'type' => $i,
                        'description_ar' => 'وصف خدمة ' . $i . '-' . ' بالعربية',
                        'description_en' => 'services description ' . $i . '-' . ' in English',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );




        }
    }

    }
