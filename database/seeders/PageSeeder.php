<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 pages
        for ($i = 1; $i <= 10; $i++) {
               DB::table('pages')->updateOrInsert(
                    [
                        'title_ar' => ' الصفحات ' . $i,
                        'title_en' => 'pages ' . $i ,
                        'status' => 1,
                        'parent_page' =>rand(1,5),
                        'tags' => 'وصف  الصفحات ' . $i . '-' .' بالعربية',
                        'description_ar' => 'وصف  الصفحات ' . $i . '-' . ' بالعربية',
                        'description_en' => 'pages description ' . $i . '-' . ' in English',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );





        }
    }

    }
