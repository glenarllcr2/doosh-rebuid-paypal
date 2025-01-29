<?php

namespace Database\Seeders;

use App\Models\InternalMessage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class InternalMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder generates 10,000 internal messages.
     * Some messages are drafts, some are sent, and some are replies.
     * Draft messages cannot be marked as read.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::all(); // Retrieve all users
        $totalMessages = 20000;

        $this->command->info("Seeding $totalMessages internal messages...");
        $bar = $this->command->getOutput()->createProgressBar($totalMessages);

        foreach (range(1, $totalMessages) as $i) {
            // Random sender and receiver
            $sender = $users->random();
            $receiver = $users->where('id', '!=', $sender->id)->random();

            // Determine if the message is a draft
            $isDraft = $faker->boolean(20); // 20% of messages are drafts

            $messageData = [
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'message' => $isDraft ? null : $faker->realText($faker->numberBetween(10, 200)),
                'status' => $isDraft ? 'draft' : 'sent',
                'sent_at' => $isDraft ? null : $faker->dateTimeBetween('-1 year', 'now'),
                'is_read' => false,
                'read_at' => null,
            ];

            // If the message is not a draft, it might be read or a reply
            if (!$isDraft) {
                $messageData['is_read'] = $faker->boolean(50); // 50% chance of being read
                if ($messageData['is_read']) {
                    $messageData['read_at'] = $faker->dateTimeBetween($messageData['sent_at'], 'now');
                }

                // Randomly make this message a reply to another sent message
                if ($faker->boolean(30)) { // 30% chance of being a reply
                    $parentMessage = InternalMessage::inRandomOrder()->where('status', 'sent')->first();
                    if ($parentMessage) {
                        $messageData['parent_id'] = $parentMessage->id;
                    }
                }
            }

            // Create the message
            InternalMessage::create($messageData);

            // Advance the progress bar
            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\nSeeding completed!");
    }

    
}
