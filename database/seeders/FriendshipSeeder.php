<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

class FriendshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();


        $consoleOutput = $this->command->getOutput();
        $progressBar = new ProgressBar($consoleOutput, $users->count());
        $progressBar->start();

        foreach ($users as $user) {
            // پیدا کردن کاربران واجد شرایط برای دوستی
            $eligibleUsers = User::select('*')
                ->where('id', '!=', $user->id)
                ->where('gender', '!=', $user->gender)
                ->whereRaw('ABS(TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) - TIMESTAMPDIFF(YEAR, ?, CURDATE())) <= 10', [$user->birth_date])
                ->get();
            //dd($eligibleUsers);
            // دوستان
            $friendIds = $eligibleUsers->random(min(10, $eligibleUsers->count()))
                ->pluck('id')
                ->toArray();

            foreach ($friendIds as $friendId) {
                $userId = min($user->id, $friendId);
                $friendId = max($user->id, $friendId);

                Friendship::updateOrCreate([
                    'user_id' => $userId,
                    'friend_id' => $friendId,
                ], [
                    'status' => 'accepted',
                ]);
            }

            // کاربران بلاک‌شده
            $remainingUsers = $eligibleUsers->whereNotIn('id', $friendIds);
            $blockedUserIds = $remainingUsers->random(min(10, $remainingUsers->count()))
                ->pluck('id')
                ->toArray();

            foreach ($blockedUserIds as $blockedId) {
                DB::table('blocks')->updateOrInsert([
                    'user_id' => $user->id,
                    'blocked_user_id' => $blockedId,
                ], [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // درخواست‌های دوستی ارسال‌شده
            $remainingUsers = $remainingUsers->whereNotIn('id', $blockedUserIds);
            $sentRequestIds = $remainingUsers->random(min(10, $remainingUsers->count()))
                ->pluck('id')
                ->toArray();

            foreach ($sentRequestIds as $sentId) {
                Friendship::updateOrCreate([
                    'user_id' => $user->id,
                    'friend_id' => $sentId,
                ], [
                    'status' => 'pending',
                ]);
            }

            // درخواست‌های دوستی دریافت‌شده
            $remainingUsers = $remainingUsers->whereNotIn('id', $sentRequestIds);
            $receivedRequestIds = $remainingUsers->random(min(10, $remainingUsers->count()))
                ->pluck('id')
                ->toArray();

            foreach ($receivedRequestIds as $receivedId) {
                Friendship::updateOrCreate([
                    'user_id' => $receivedId,
                    'friend_id' => $user->id,
                ], [
                    'status' => 'pending',
                ]);
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->info("\nFriendship seeding completed.");
    }
}
