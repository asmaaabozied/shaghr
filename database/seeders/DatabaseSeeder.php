<?php

namespace Database\Seeders;

use App\Services\Rooms\RoomTypeService;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FacilitySeeder::class);
        $this->call(ChainsSeeder::class);
        $this->call(HotelsSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(AmenitySeeder::class);
        $this->call(AmenityTypeSeeder::class);
       $this->call(TestimonialSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(AvailablitySeeder::class);
        $this->call(RoomTypesSeeder::class);
        $this->call(BookingSeeder::class);

    }
}
