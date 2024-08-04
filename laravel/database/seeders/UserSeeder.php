<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pass = bcrypt('password');
        $now = now();
        $batchSize = 2000;


        for ($i = 1; $i <= 2000001; $i++) {
            $data[] = [
                'fullname' => 'user' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => $pass,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];


            if ($i % $batchSize === 0) {
                $this->insertBatch($data, $i);
                $data = [];
            }
        }


        if (!empty($data)) {
            $this->insertBatch($data, $i - 1);
        }
    }


    private function insertBatch(array $data, int $count): void
    {
        DB::table('users')->insert($data);
        echo "Inserted {$count} rows." . PHP_EOL;
    }
}
