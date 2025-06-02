<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Loop to create 10 testimonials
        for ($i = 1; $i <= 10; $i++) {
               DB::table('testimonials')->updateOrInsert(
                    [
                        'name_ar' => 'شهادة ' . $i,
                        'name_en' => 'testimonial ' . $i,
                        'active' => 1,
                        'Published' => 1,
                        'Status' =>'Pending',
                        'rating' => rand(1, 5),
                        'position' => $i,
                        'review_text_ar' => 'وصف شهادة ' . $i . '-' . ' بالعربية',
                        'review_text_en' => 'testimonial description ' . $i . '-' . ' in English',
                        'submission_date' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,

                    ]
                );


            }



    }

    }
