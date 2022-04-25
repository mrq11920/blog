<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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
            $type = $i % 10 == 0 ? config('user.admin'):config('user.user');
          
            DB::table('users')->insert([
                'name' => $faker->name(),
                'type' => $type,
                'email' => $faker->unique()->email(),
                'password' => Hash::make('Q.ewr2333@@@%')
            ]);
        }
    }
}
