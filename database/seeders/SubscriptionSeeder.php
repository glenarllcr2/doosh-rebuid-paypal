<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Carbon;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        $users = User::all(); // All users
        $plans = [30, 90, 365]; // Plan durations: 1 month, 3 months, 1 year
        $totalUsers = $users->count();

        $this->command->info("Creating subscriptions for $totalUsers users...");
        $this->command->getOutput()->progressStart($totalUsers);

        foreach ($users as $user) {
            $startDate = Carbon::now()->subDays(rand(1, 30));//Start from a random date in the last month
            $duration = $plans[array_rand($plans)];// Randomly select a plan
            $endDate = (clone $startDate)->addDays($duration); // Calculate the end date

            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => rand(1, 3),// Suppose we have 3 plans
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            // Update Progress Bar
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info("Completed creating subscriptions for $totalUsers users!");
    }
}
