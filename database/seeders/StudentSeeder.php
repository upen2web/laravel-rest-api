<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach(range(1,5) as $index) {
            DB::table('students')->insert([
                'name'=>$faker->name(),
                'city'=>$faker->city(),
                'fees'=>$faker->randomNumber(),
            ]);
        }
    }
}
