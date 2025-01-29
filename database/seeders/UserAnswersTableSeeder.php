<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Question;
use App\Models\UserAnswer;
use Symfony\Component\Console\Helper\ProgressBar;

class UserAnswersTableSeeder extends Seeder
{
    public $countries = [
                'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina',
                'Armenia', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados',
                'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina',
                'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cabo Verde', 'Cambodia',
                'Cameroon', 'Canada', 'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia',
                'Comoros', 'Congo, Democratic Republic of the', 'Congo, Republic of the', 'Costa Rica',
                'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica',
                'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea',
                'Estonia', 'Eswatini', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia',
                'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana',
                'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq',
                'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya',
                'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia',
                'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Madagascar', 'Malawi', 'Malaysia',
                'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico',
                'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique',
                'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua',
                'Niger', 'Nigeria', 'North Macedonia', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine',
                'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal',
                'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia',
                'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe',
                'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore',
                'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Korea',
                'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Sweden', 'Switzerland',
                'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo',
                'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu',
                'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States',
                'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam',
                'Yemen', 'Zambia', 'Zimbabwe',
    ];
    public $ideal_living_places =  ['North America', 'Europe', 'Australia', 'Middle East', 'Other'];
    public $industry=  ['Medicine', 'Computer & Technology', 'Education', 'Finance', 'Real Estate', 'Accounting', 'Marketing', 'Other'];
    public $church = ['Church of the East', 'The Ancient Church of the East', 'Protestant', 'Catholic', 'Other'];
    public $education = ['Ph.D. Degree', 'Master Degree', 'Bachelor Degree', 'Associate Degree', 'Other'];
    public $movie_genre = ['Action', 'Drama', 'Comedy', 'Horror', 'Sci-Fi', 'Classics', 'Faith', 'Family Movies', 'Romance', 'Other'];
    public $news_media = ['CNN', 'BBC', 'Fox News', 'NBC', 'CBS', 'Newspaper', 'Other'];
    public $social_medias = ['Facebook', 'Instagram', 'WhatsApp', 'TikTok', 'Telegram', 'Pinterest', 'Skype', 'Viber', 'Discord', 'Tumblr', 'Twitter'];
    public $singers = ['Linda George', 'Juliana Jendo', 'Sargon Gabriel', 'Ashur Bet Sargis', 'Evin Aghassi', 'Other'];
    public $foods = ['Booshala', 'Kipteh', 'Dolmeh', 'Biryani', 'Kubba', 'Other'];
    public function run()
    {
        // Faker instance for generating fake data
        $faker = Faker::create();

        // Fetch all users
        $users = User::all();

        // Fetch all questions
        $questions = Question::all();

        // Initialize progress bar
        $consoleOutput = $this->command->getOutput();
        $progressBar = new ProgressBar($consoleOutput, $users->count());

        foreach ($users as $user) {
            // Calculate user's age based on birth_date
            $age = now()->year - \Carbon\Carbon::parse($user->birth_date)->year;

            foreach ($questions as $question) {
                // Prepare the answer value based on question and user's details
                //dd($question);
                $answer = $this->generateAnswer($question, $user, $age, $faker);

                // Check if the answer is valid and not null
                if (!$answer) {
                    // If no valid answer, set a default answer
                    $answer = '1';
                }

                // Store the answer in the user_answers table
                UserAnswer::create([
                    'user_id' => $user->id,
                    'question_id' => $question->id,
                    'answer_value' => $answer
                ]);
            }

            // Update progress bar
            $progressBar->advance();
        }

        $progressBar->finish();
    }

    /**
     * Generate a random answer based on the question type, user's details (age, gender), and faker data.
     *
     * @param Question $question
     * @param User $user
     * @param int $age
     * @param Faker\Generator $faker
     * @return string
     */
    private function generateAnswer($question, $user, $age, $faker)
    {
        switch ($question->answer_type) {
            case 'text':
                return $faker->name;
            case 'numeric':
                // برای مقادیر عددی (مثل قد یا تعداد خواهر و برادر)
                return $this->generateNumericAnswer($question, $user, $age, $faker);
            case 'single_select':
                
                $test = $this->getSingleSelectAnswer($question, $user, $faker);
                
                return $this->getSingleSelectAnswer($question, $user, $faker);
            case 'multi_select':
                return $this->getMultiSelectAnswer($question, $user, $faker);
            case 'boolean' :
                //echo $question->question;
                // if($question->question_key == 'sports_play')
                //     echo 'sport_play';
                return $faker->boolean();
            default:
                return '';
        }
    }

    private function generateNumericAnswer($question, $user, $age, $faker)
    {
        if ($question->question_key == 'height') {
            // برای انتخاب تصادفی قد به واحد "feet" و "inches"
            $feet = $faker->numberBetween(4, 6); // انتخاب تصادفی عددی برای feet (۴ تا ۶ فوت)
            $inches = $faker->numberBetween(0, 11); // انتخاب تصادفی عددی برای inches (۰ تا ۱۱ اینچ)
            
            return "{$feet}' {$inches}\"";
        } elseif ($question->question_key == 'siblings') {
            // محدود کردن تعداد خواهر و برادر به ۱۰
            return $faker->numberBetween(0, 6);
        }
        // برای دیگر سوالات عددی می‌توانیم از مقدار طبیعی استفاده کنیم
        return $faker->numberBetween(20, 100); // مثال دیگر
    }



    /**
     * Generate single select answer based on user gender and age.
     *
     * @param Question $question
     * @param User $user
     * @param Faker\Generator $faker
     * @return string
     */
    private function getSingleSelectAnswer($question, $user, $faker)
    {
        //dd($question->question_key);
        if ($question->question_key == 'industry') {
            
            return $faker->randomElement($this->industry);
        } elseif ($question->question_key == 'church') {
            
            return $faker->randomElement($this->church);
        } elseif ($question->question_key == 'education') {
            
            return $faker->randomElement($this->education);
        } elseif ($question->question_key == 'movie_genre') {
            
            return $faker->randomElement($this->movie_genre);
        } elseif ($question->question_key == 'new_media') {
            
            return $faker->randomElement($this->news_media);
        } elseif ($question->question_key == 'ideal_living_places') {
            
            return $faker->randomElement($this->ideal_living_places);
        } elseif ($question->question_key == 'ideal_living_places') {
            
            return $faker->randomElement($this->ideal_living_places);
        } elseif ($question->question_key == 'country_live' || $question->question_key == 'country_born') {
            
            return $faker->randomElement($this->countries);
        }

        
        // Handle other single select questions
        return $faker->randomElement($question->options->pluck('option_value')->toArray());
    }

    /**
     * Generate multi select answer based on user preferences (for example, favorite movies).
     *
     * @param Question $question
     * @param User $user
     * @param Faker\Generator $faker
     * @return string
     */
    private function getMultiSelectAnswer($question, $user, $faker)
    {
        // گرفتن گزینه‌های سوال
        $options = $question->options->pluck('option_value')->toArray();

        // اگر گزینه‌ها کمتر از 2 بود، تمام گزینه‌ها را به طور تصادفی انتخاب کن
        $numOptionsToSelect = min(count($options), 2);

        if ($question->question_key == 'favorite_movie') {
            return implode(', ', $faker->randomElements($this->movie_genre, count($this->movie_genre) -1));
        } else if ($question->question_key == 'news_media') {
            return implode(', ', $faker->randomElements($this->news_media, count($this->news_media ) -1));
        } else if ($question->question_key == 'ideal_place') {
            return implode(', ', $faker->randomElements($this->ideal_living_places, count($this->ideal_living_places) -1));
        } else if ($question->question_key == 'ideal_family_place') {
            return implode(', ', $faker->randomElements($this->ideal_living_places, count($this->ideal_living_places) -1));
        } else if ($question->question_key == 'social_media') {
            return implode(', ', $faker->randomElements($this->social_medias, count($this->social_medias) -1));
        } else if ($question->question_key == 'assyrian_singer') {
            return implode(', ', $faker->randomElements($this->singers, count($this->singers) -1));
        } else if ($question->question_key == 'assyrian_food') {
            return implode(', ', $faker->randomElements($this->foods, count($this->foods) -1));
        }

        // اگر گزینه‌ها کمتر از 2 تا بود، تعداد صحیح انتخاب را انجام بدهیم
        return implode(', ', $faker->randomElements($options, $numOptionsToSelect));
    }
}
