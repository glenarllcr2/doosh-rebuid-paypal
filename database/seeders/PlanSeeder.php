<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        // Define plans and accesses
        $plans = [
            [
                'name' => 'Plan A',
                'price' => 100,
                'description' => 'Full access',
                'permissions' => [1, 2, 3, 4], // All accesses
            ],
            [
                'name' => 'Plan B',
                'price' => 50,
                'description' => 'Basic access',
                'permissions' => [1, 2], // Emoji and SMS
            ],
            [
                'name' => 'Plan C',
                'price' => 20,
                'description' => 'Emoji only',
                'permissions' => [1], // Emoji only
            ],
        ];

        // Create plans and assign access
        foreach ($plans as $planData) {
            $plan = Plan::create([
                'name' => $planData['name'],
                'price' => $planData['price'],
                'description' => $planData['description'],
            ]);

            $plan->permissions()->attach($planData['permissions']);
        }
    }
}
