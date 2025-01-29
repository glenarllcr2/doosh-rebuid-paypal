<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $totalUsers = 1000;

        $this->command->info("Creating $totalUsers users...");
        $this->command->getOutput()->progressStart($totalUsers);

        // 1. Add specific users with predefined data
        $users = [
            [
                'first_name' => 'Reza',
                'middle_name' => 'M',
                'last_name' => 'Bagheri',
                'display_name' => 'reza bagheri',
                'email' => 'rezabagheri@gmail.com',
                'phone_number' => '09120000001',
                'gender' => 'male',
                'birth_date' => '1974-08-11',
                'status' => 'active',
                'role_id' => 1, // Super Admin
                'password' => Hash::make('reza@2231353'),
            ],
            [
                'first_name' => 'Ramsin',
                'middle_name' => 'Ra',
                'last_name' => 'Savra',
                'display_name' => 'ramsin savra',
                'email' => 'ramsin.savra@gmail.com',
                'phone_number' => '09120000002',
                'gender' => 'male',
                'birth_date' => '1972-11-06',
                'status' => 'active',
                'role_id' => 1, // Super Admin
                'password' => Hash::make('ramsin@1234'),
            ]
        ];

        User::insert($users);

        for ($i = 0; $i < $totalUsers; $i++) {
            // Random gender selection
            $gender = $faker->randomElement(['male', 'female']);
            
            // Create user
            User::create([
                'first_name' => $gender === 'male' ? $faker->firstNameMale : $faker->firstNameFemale,
                'middle_name' => $faker->optional()->lastName,// Middle name may be empty
                'last_name' => $faker->lastName,
                'display_name' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->unique()->phoneNumber,
                'gender' => $gender,
                'birth_date' => $faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'), // Age between 18 and 50 years
                'status' => $faker->randomElement(['active', 'pending', 'suspended', 'blocked']),
                'role_id' => $faker->numberBetween(1, 4), // Assume there are 4 roles available
                'password' => Hash::make('password'), // Default password
            ]);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        $this->command->info("Completed creating $totalUsers users!");
        
    }
}
