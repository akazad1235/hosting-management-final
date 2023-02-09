<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $gender = $faker->randomElement(['name', 'email', 'password', 'status']);

    	foreach (range(1,100000) as $index) {
            $email = $faker->email; 
            if(User::whereEmail($email)->count() > 0){
                $email = $faker->email; 
            } else {
                DB::table('users')->insert([
                    'name' => $faker->name,
                    'email' => $email,
                    'password' => Hash::make('12345678'),
                    'status' => 'open',
                ]);
            }
        }
        // User::factory(10)->create();
    }
}
