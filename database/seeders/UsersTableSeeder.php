<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();
        $limit = 20;

        for ($i = 0; $i < $limit; $i++) {
            // 'name',
            // 'email',
            // 'password',
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->email(),
                'password' => $faker->password()
            ]);
        }
    }
}
