<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $totalRows = 50000;      // Total records
        $batchSize = 1000;        // Insert in batches of 1000
        $batches = ceil($totalRows / $batchSize);

        for ($batch = 1; $batch <= $batches; $batch++) {
            $data = [];

            for ($i = 0; $i < $batchSize; $i++) {
                $data[] = [
                    'name' => ucwords($faker->name),
                    'date' => $faker->dateTimeBetween('2020-01-01', '2025-12-31')->format('Y-m-d H:i:s'),
                    'category_id' => $faker->numberBetween(1, 15),
                    'created_by' => 1,
                    'status' => $faker->randomElement(['Published', 'Draft']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('posts')->insert($data);

            // Optional: show progress in console
            $this->command->info("Batch {$batch} of {$batches} inserted...");
        }

        $this->command->info("✅ {$totalRows} posts seeded successfully!");
    }
}













//namespace Database\Seeders;
//
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;
//use Faker\Factory as Faker;
//use Illuminate\Support\Facades\DB;
//
//class PostSeeder extends Seeder
//{
//    /**
//     * Run the database seeds.
//     */
//    public function run(): void
//    {
//        $faker = Faker::create();
//
//        foreach (range(1, 500) as $index) {
//            DB::table('posts')->insert([
//                'name' => ucwords($faker->name),
//                'date' => $faker->dateTimeBetween('2020-01-01', '2025-12-31')->format('Y-m-d H:i:s'),
//                'category_id' => $faker->numberBetween(1, 15),
//                'created_by' => 1,
//                'status' =>  $faker->randomElement(['Published', 'Draft']),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);
//        }
//
//    }
//}
