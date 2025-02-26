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

        foreach (range(1, 1000) as $index) {
            DB::table('posts')->insert([
                'name' => $faker->word,
                'category_id' => $faker->numberBetween(1, 15),
                'status' =>  $faker->randomElement(['published', 'draft']),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
