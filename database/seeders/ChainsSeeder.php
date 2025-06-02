<?php

namespace Database\Seeders;

use App\Models\Chains\Chains;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChainsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch all users with the 'owner' role (you can customize this logic based on your needs)
        $owners = User::role('owner')->get();

        // Check if we have enough owner users to create chains
        if ($owners->isEmpty()) {
            echo "No owners found, please ensure you have users with the 'owner' role in the database.\n";
            return;
        }
        foreach ($owners as $owner) {
            for ($i = 1; $i <= 3; $i++) {
                Chains::updateOrCreate(
                    ['name_en' => 'Chain ' . $owner->id . ' - ' . $i],
                    [
                        'user_id' => $owner->id,
                        'name_en' => 'Chain ' . $owner->id . ' - ' . $i,
                        'name_ar' => 'سلسلة ' . $owner->id . ' - ' . $i,
                        'hotels_count' => 0,
                        'creator_id' => $owner->id,
                        'update_id' => $owner->id,
                        'delete_id' => null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null
                    ]
                );
            }
        }

    }
}
