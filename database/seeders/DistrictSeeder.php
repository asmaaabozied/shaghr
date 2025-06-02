<?php

namespace Database\Seeders;

use App\Models\Places\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $districts = json_decode(Storage::disk('local')->get('districts.json'), true);
        foreach ($districts as $district) {
            District::firstOrCreate(
                [
                    'name_en' => $district['name_en'],
                    'name_ar' => $district['name_ar'],
                    'city_id' => $district['city_id']
                ],
                [
                    'is_active' => true
                ]
            );
        }
    }
}
