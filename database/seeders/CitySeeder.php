<?php

namespace Database\Seeders;

use App\Models\Places\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = json_decode(Storage::disk('local')->get('cities.json'), true);
        $country = \App\Models\Places\Country::where('name_en' , 'Saudi Arabia')->first();
        foreach ($cities as $city) {
            $existingCity = City::where('name_en', $city['name_en'])
                ->orWhere('name_ar', $city['name_ar'])
                ->where('country_id', $country->id)  // Make sure it's in the correct country
                ->first();
            if (!$existingCity) {
                City::create([
                    'name_en' => $city['name_en'],
                    'name_ar' => $city['name_ar'],
                    'is_active' => true,
                    'country_id' => $country->id
                ]);
            }

        }
    }
}
