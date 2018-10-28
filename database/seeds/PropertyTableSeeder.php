<?php

use Illuminate\Database\Seeder;

class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Property::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            \App\Property::create([
                'address1' => $faker->streetName,
                'address2' => $faker->streetAddress,
                'city' => $faker->city,
                'postcode' => $faker->postcode,
            ]);
        }

    }
}
