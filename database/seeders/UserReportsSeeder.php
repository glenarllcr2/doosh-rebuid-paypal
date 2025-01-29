<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserReport;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class UserReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Fetch all user IDs from the users table
        $userIds = User::pluck('id')->toArray();

        // Generate 100 fake reports
        for ($i = 0; $i < 100; $i++) {
            $userId = $faker->randomElement($userIds); // Reporter ID
            $targetId = $faker->randomElement($userIds); // Target ID

            // Ensure reporter and target are not the same
            while ($userId === $targetId) {
                $targetId = $faker->randomElement($userIds);
            }

            $status = $faker->randomElement(['pending', 'accepted', 'regected']);

            // Create the base report data
            $report = UserReport::create([
                'user_id' => $userId,
                'target_id' => $targetId,
                'report' => $faker->sentence(10),
                'status' => $status,
                'page_url' => $faker->url,
                'user_agent' => $faker->userAgent,
                'created_at' => $createdAt = $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $createdAt,
            ]);

            // If the report is accepted or rejected, add review_date and answer
            if (in_array($status, ['accepted', 'rejected'])) {
                $reviewDate = $faker->dateTimeBetween($createdAt, 'now');
                $report->update([
                    'review_date' => $reviewDate,
                    'answer' => $faker->sentence(15),
                ]);
            }
        }
    }
}
