<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
        for ($i = 20; $i <= 30; $i++) {
            DB::table('user_catalogues')->insert([
                'name' => 'User Catalogue ' . $i,
                'code' => 'Code' . $i,
                'description' => 'Description of User ' . $i,
                // Các trường dữ liệu khác nếu có
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
=======
        DB::table('user_catalogues')->insert([
            ['id' => 1, 'name' => 'Quản trị viên', 'code' => 'admin', 'description' => 'Người có quyền hành cao nhất', 'publish' => 1, 'deleted_at' => null, 'created_at' => '2024-07-20 05:47:27', 'updated_at' => '2024-07-20 05:47:27'],
            ['id' => 2, 'name' => 'Khách hàng', 'code' => 'customer', 'description' => 'Không có quyền truy cập vào trang quản trị', 'publish' => 1, 'deleted_at' => null, 'created_at' => '2024-07-20 05:48:34', 'updated_at' => '2024-08-04 08:36:22'],
        ]);
>>>>>>> e2648f7deaca20ab76e760771c24c39219568e08
    }
}
