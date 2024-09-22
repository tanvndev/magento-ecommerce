<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => 'Tạo mới thành viên', 'canonical' => 'users.store', 'created_at' => '2024-07-20 05:30:18', 'updated_at' => '2024-07-20 05:30:18'],
            ['id' => 2, 'name' => 'Xem nhiều thành viên', 'canonical' => 'users.index', 'created_at' => '2024-07-20 05:30:18', 'updated_at' => '2024-07-20 05:30:18'],
            ['id' => 3, 'name' => 'Xem một thành viên', 'canonical' => 'users.show', 'created_at' => '2024-07-20 05:30:18', 'updated_at' => '2024-07-20 05:30:18'],
            ['id' => 4, 'name' => 'Chỉnh sửa thành viên', 'canonical' => 'users.update', 'created_at' => '2024-07-20 05:30:18', 'updated_at' => '2024-07-20 05:30:18'],
            ['id' => 5, 'name' => 'Xóa thành viên', 'canonical' => 'users.destroy', 'created_at' => '2024-07-20 05:30:18', 'updated_at' => '2024-07-20 05:30:18'],
            ['id' => 6, 'name' => 'Tạo mới quyền người dùng', 'canonical' => 'permissions.store', 'created_at' => '2024-07-20 05:37:08', 'updated_at' => '2024-07-20 05:37:08'],
            ['id' => 7, 'name' => 'Xem nhiều quyền người dùng', 'canonical' => 'permissions.index', 'created_at' => '2024-07-20 05:37:08', 'updated_at' => '2024-07-20 05:37:08'],
            ['id' => 8, 'name' => 'Xem một quyền người dùng', 'canonical' => 'permissions.show', 'created_at' => '2024-07-20 05:37:08', 'updated_at' => '2024-07-20 05:37:08'],
            ['id' => 9, 'name' => 'Chỉnh sửa quyền người dùng', 'canonical' => 'permissions.update', 'created_at' => '2024-07-20 05:37:08', 'updated_at' => '2024-07-20 05:37:08'],
            ['id' => 10, 'name' => 'Xóa quyền người dùng', 'canonical' => 'permissions.destroy', 'created_at' => '2024-07-20 05:37:08', 'updated_at' => '2024-07-20 05:41:16'],
            ['id' => 11, 'name' => 'Cập nhật quyền cho người dùng', 'canonical' => 'users.catalogues.updatePermissions', 'created_at' => '2024-07-21 10:34:09', 'updated_at' => '2024-07-21 10:34:09'],
            ['id' => 12, 'name' => 'Tạo mới nhóm thành viên', 'canonical' => 'users.catalogues.store', 'created_at' => '2024-07-21 10:34:51', 'updated_at' => '2024-07-21 10:34:51'],
            ['id' => 13, 'name' => 'Xem nhiều nhóm thành viên', 'canonical' => 'users.catalogues.index', 'created_at' => '2024-07-21 10:34:51', 'updated_at' => '2024-07-21 10:34:51'],
            ['id' => 14, 'name' => 'Xem một nhóm thành viên', 'canonical' => 'users.catalogues.show', 'created_at' => '2024-07-21 10:34:51', 'updated_at' => '2024-07-21 10:34:51'],
            ['id' => 15, 'name' => 'Chỉnh sửa nhóm thành viên', 'canonical' => 'users.catalogues.update', 'created_at' => '2024-07-21 10:34:51', 'updated_at' => '2024-07-21 10:34:51'],
            ['id' => 16, 'name' => 'Xóa nhóm thành viên', 'canonical' => 'users.catalogues.destroy', 'created_at' => '2024-07-21 10:34:51', 'updated_at' => '2024-07-21 10:34:51'],
        ]);
    }
}
