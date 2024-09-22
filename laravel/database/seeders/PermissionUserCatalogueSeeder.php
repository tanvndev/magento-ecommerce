<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionUserCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permission_user_catalogue')->insert([
            ['user_catalogue_id' => 1, 'permission_id' => 1],
            ['user_catalogue_id' => 1, 'permission_id' => 2],
            ['user_catalogue_id' => 1, 'permission_id' => 3],
            ['user_catalogue_id' => 1, 'permission_id' => 4],
            ['user_catalogue_id' => 1, 'permission_id' => 5],
            ['user_catalogue_id' => 1, 'permission_id' => 6],
            ['user_catalogue_id' => 1, 'permission_id' => 7],
            ['user_catalogue_id' => 1, 'permission_id' => 8],
            ['user_catalogue_id' => 1, 'permission_id' => 9],
            ['user_catalogue_id' => 1, 'permission_id' => 10],
            ['user_catalogue_id' => 1, 'permission_id' => 11],
            ['user_catalogue_id' => 1, 'permission_id' => 12],
            ['user_catalogue_id' => 1, 'permission_id' => 13],
            ['user_catalogue_id' => 1, 'permission_id' => 14],
            ['user_catalogue_id' => 1, 'permission_id' => 15],
            ['user_catalogue_id' => 1, 'permission_id' => 16],
        ]);
    }
}
