<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        DB::table('permissions')->delete();
        DB::table('roles')->delete();
        $models = ['contacts', 'sliders', 'services', 'settings', 'permissions', 'users', 'roles', 'pages', 'faqs', 'features', 'amenities-types', 'amenities', 'testimonials', 'image-galleries', 'availabilities', 'rooms'];


        $maps = ['create', 'update', 'read', 'delete'];

        $permissions = array();

        foreach ($models as $model) {
            foreach ($maps as $map) {
                $data = $map . '_' . $model;
                array_push($permissions, $data);
                Permission::create(['name' => $data]);

            }
        }


        $role =  Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'owner']);
        Role::firstOrCreate(['name' => 'user']);
        $role->givePermissionTo($permissions);


    }
}
