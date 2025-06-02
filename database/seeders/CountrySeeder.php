<?php


namespace Database\Seeders;

use App\Models\Places\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = json_decode(Storage::disk('local')->get('world_en.json'), true);

        foreach ($countries as $country){
            $existingCountry = Country::where('name_en', $country['name'])
                ->orWhere('code', '+' . $this->code(Str::upper($country['alpha2'])))
                ->first();

            // If country doesn't exist, create it
            if (!$existingCountry) {
                Country::create([
                    'name_ar' => $this->getNameAr($country['alpha2']),
                    'name_en' => $country['name'],
                    'code' => '+' . $this->code(Str::upper($country['alpha2'])) ?? null,
                    'is_active' => true,
                    // 'icon' => $this->getFlag($country['alpha2'])  // You can add this if needed
                ]);
            }
        }

    }

    private function code($code){

        $countries = json_decode(Storage::disk('local')->get('country-codes.json'), true);
        // Search for the item with alpha2 value "al"
        $result = collect($countries)->firstWhere('Iso2', $code);
        // Retrieve the name value from the result
        $string =  $result['Dial'] ?? $code;
        if (strpos($string, '-') !== false) {
            $parts = explode('-', $string);
            $firstItem = $parts[0];
            return $firstItem;
        }
        return $string;

    }

    private function getNameAr($code){
        $countries = json_decode(Storage::disk('local')->get('world_ar.json'), true);
        // Search for the item with alpha2 value "al"
        $result = collect($countries)->firstWhere('alpha2', $code);
        // Retrieve the name value from the result
        return $result['name'];
    }


    private function getFlag($code){
        $flags = json_decode(Storage::disk('local')->get('flags.json'), true);
        return $flags[$code];
    }
}



