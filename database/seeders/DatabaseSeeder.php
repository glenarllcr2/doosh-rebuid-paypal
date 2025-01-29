<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            MediaSeeder::class,
            PermissionsSeeder::class,
            PlanSeeder::class,
            SubscriptionSeeder::class,
            FriendshipSeeder::class,
            InternalMessageSeeder::class,
            QuestionsTableSeeder::class,
            QuestionOptionsTableSeeder::class,
            UserAnswersTableSeeder::class,
        ]);
    }
}
