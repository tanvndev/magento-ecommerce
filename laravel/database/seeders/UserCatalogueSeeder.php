<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 20; $i <= 30; $i++) {
            DB::table('user_catalogues')->insert([
                'name' => 'User Catalogue ' . $i,
                'description' => 'Description of User ' . $i,
                // Các trường dữ liệu khác nếu có
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
