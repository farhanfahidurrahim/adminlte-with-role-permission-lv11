<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        foreach (range(1, 500) as $index) {
            DB::table('posts')->insert([
                'name' => ucwords($faker->name),
                'date' => $faker->dateTimeBetween('2020-01-01', '2025-12-31')->format('Y-m-d H:i:s'),
                'category_id' => $faker->numberBetween(1, 15),
                'created_by' => 1,
                'status' =>  $faker->randomElement(['published', 'draft']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
