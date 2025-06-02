<?php

namespace Database\Seeders;

use App\Models\Rooms\RoomTypes;
use Illuminate\Database\Seeder;

class RoomTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomTypes::firstOrCreate(
            ['name_en' => 'Single'], // Check for the English name 'Single'
            [
                'name_ar' => 'فردي', // Arabic name
                'description_en' => 'A single room with one bed, perfect for solo travelers.',
                'description_ar' => 'غرفة فردية تحتوي على سرير واحد، مثالية للمسافرين المنفردين.',
                'capacity' => 1,
            ]
        );

        RoomTypes::firstOrCreate(
            ['name_en' => 'Double'], // Check for the English name 'Double'
            [
                'name_ar' => 'مزدوج', // Arabic name
                'description_en' => 'A room with two beds, ideal for couples or friends sharing.',
                'description_ar' => 'غرفة بها سريرين، مثالية للأزواج أو الأصدقاء المشتركين.',
                'capacity' => 2,
            ]
        );

        RoomTypes::firstOrCreate(
            ['name_en' => 'Suite'], // Check for the English name 'Suite'
            [
                'name_ar' => 'جناح', // Arabic name
                'description_en' => 'A luxury room with a king-sized bed, living area, and additional amenities.',
                'description_ar' => 'غرفة فاخرة تحتوي على سرير بحجم ملكي، منطقة معيشة، ووسائل راحة إضافية.',
                'capacity' => 4,
            ]
        );
    }
}
