<?php
namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a progress bar for user count
        $progressBar = $this->command->getOutput()->createProgressBar(User::count());
        $progressBar->start();

        // Define folders for male and female images
        $folders = ['male', 'female'];

        // Prepare data for bulk insert
        $profileMediaData = [];
        $albumMediaData = [];

        // Assume images are stored in 'storage/app/public/images/male' and 'storage/app/public/images/female'
        $maleImages = Storage::disk('public')->files('images/male');
        $femaleImages = Storage::disk('public')->files('images/female');

        // Loop through all users
        User::each(function ($user) use ($folders, $maleImages, $femaleImages, $progressBar, &$profileMediaData, &$albumMediaData) {
            // Select the correct folder based on the user's gender
            $genderFolder = $user->gender === 'male' ? 'male' : 'female';
            $imageFiles = $genderFolder === 'male' ? $maleImages : $femaleImages;

            // Select a random image for the profile
            $profileImagePath = $imageFiles[array_rand($imageFiles)];
            $profileImageUrl = 'images/' . $genderFolder . '/' . basename($profileImagePath);

            // Collect data for profile media (no need for mime type and size in this case)
            $profileMediaData[] = [
                'url' => $profileImageUrl,
                'type' => 'profile',
                'mime_type' => 'image', // We don't need to check mime type since the images are predefined
                'size' => 25000, // Fixed size (no need to use filesize)
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert the profile media and associate with the user
            $profileMediaId = Media::create($profileMediaData[count($profileMediaData) - 1])->id;
            $user->medias()->attach($profileMediaId, ['is_profile' => true, 'is_approved' => true]);

            // Create album photos (between 8 and 10 photos)
            $albumPhotosCount = rand(8, 10);
            $albumImages = array_diff($imageFiles, [$profileImagePath]); // Exclude the profile image from album

            for ($i = 0; $i < $albumPhotosCount; $i++) {
                $albumImagePath = $albumImages[array_rand($albumImages)];
                $albumImageUrl = 'images/' . $genderFolder . '/' . basename($albumImagePath);

                // Collect data for album media
                $albumMediaData[] = [
                    'url' => $albumImageUrl,
                    'type' => 'album',
                    'mime_type' => 'image', // Same as profile, predefined images
                    'size' => 25000, // Fixed size
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert the album media and associate with the user
                $albumMediaId = Media::create($albumMediaData[count($albumMediaData) - 1])->id;
                $user->medias()->attach($albumMediaId, ['is_profile' => false, 'is_approved' => true]);
            }

            // Advance the progress bar
            $progressBar->advance();
        });

        // Insert all collected media data into the database
        if (count($profileMediaData) > 0) {
            Media::insert($profileMediaData);
        }
        if (count($albumMediaData) > 0) {
            Media::insert($albumMediaData);
        }

        // Finish the progress bar
        $progressBar->finish();
    }
}
