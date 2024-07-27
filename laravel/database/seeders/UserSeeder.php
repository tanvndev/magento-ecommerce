<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(1000)->create();

        $data = [];
        $pass = bcrypt('password');
        $now = now();
        for ($i = 1; $i <= 1000001; $i++) {

            $data[] = [
                'fullname' => 'user' . $i,
                'email' => 'user' . $i . '@example.com',
                'user_catalogue_id' => rand(1, 3),
                'password' => $pass,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if ($i % 1000 == 0) {
                DB::table('users')->insert($data);
                echo 'Inserted ' . $i . ' users.' . PHP_EOL;
                $data = [];
            }
        }
    }
}
