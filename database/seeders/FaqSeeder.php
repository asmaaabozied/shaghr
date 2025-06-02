<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 faqs
        for ($i = 1; $i <= 10; $i++) {
               DB::table('faqs')->updateOrInsert(
                    [
                        'title_ar' => 'الأسئلة الشائعة ' . $i,
                        'title_en' => 'faqs ' . $i,
                        'status' => 1,
                        'category' => 'Hotels',
                        'body_ar' => 'وصف الأسئلة الشائعة ' . $i . '-' . ' بالعربية',
                        'body_en' => 'faqs description ' . $i . '-' . ' in English',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );





        }
    }

    }
