<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {


        // Define admin data (this will be reused)
        $adminData = [
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email_verified_at' => now(),
            'phone' => '0987654321',
            'phone_verified_at' => now(),
            'password' => Hash::make('password'), // Hash the password
            'image' => null,
            'is_active' => 1, // active
            'birthday' => '1980-12-25',
            'gender' => 'male',
            'address' => 'Admin Address, City',
        ];

        // Create or update admin users
        User::updateOrCreate(
            ['email' => 'admin@shagr.com'], // Unique condition
            array_merge($adminData, ['first_name' => 'Admin', 'last_name' => 'User'])
        )->assignRole('admin'); // Assign role to admin

        User::updateOrCreate(
            ['email' => 'admin2@shagr.com'], // Unique condition
            array_merge($adminData, ['first_name' => 'Admin2', 'last_name' => 'User','phone' => '0987654320'])
        )->assignRole('admin'); // Assign role to admin

        // Create or update owner users
        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => 'owner' . $i . '@shagr.com'], // Unique condition
                array_merge($adminData, [
                    'first_name' => 'Owner' . $i,
                    'last_name' => 'User' . $i,
                    'phone' => '098765432100' . $i
                ])
            )->assignRole('owner'); // Assign role to owner
        }

        // Create or update regular users
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => 'user' . $i . '@shagr.com'], // Unique condition
                array_merge($adminData, [
                    'first_name' => 'Owner' . $i,
                    'last_name' => 'User' . $i,
                    'phone' => '098765432105' . $i
                ])
            )->assignRole('user'); // Assign role to user
        }
    }
}
