<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            //'gender' => ['male', 'female'],
            'industry' => ['Medicine', 'Computer & Technology', 'Education', 'Finance', 'Real Estate', 'Accounting', 'Marketing', 'Other'],
            'country' => [
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
            ],
            'church' => ['Church of the East', 'The Ancient Church of the East', 'Protestant', 'Catholic', 'Other'],
            'education' => ['Ph.D. Degree', 'Master Degree', 'Bachelor Degree', 'Associate Degree', 'Other'],
            'movie_genre' => ['Action', 'Drama', 'Comedy', 'Horror', 'Sci-Fi', 'Classics', 'Faith', 'Family Movies', 'Romance', 'Other'],
            'news_media' => ['CNN', 'BBC', 'Fox News', 'NBC', 'CBS', 'Newspaper', 'Other'],
            'ideal_living_places' => ['North America', 'Europe', 'Australia', 'Middle East', 'Other'],
            'singers' => ['Linda George', 'Juliana Jendo', 'Sargon Gabriel', 'Ashur Bet Sargis', 'Evin Aghassi', 'Other'],
            'foods' => ['Booshala', 'Kipteh', 'Dolmeh', 'Biryani', 'Kubba', 'Other'],
            'social_medias' => ['Facebook', 'Instagram', 'WhatsApp', 'TikTok', 'Telegram', 'Pinterest', 'Skype', 'Viber', 'Discord', 'Tumblr', 'Twitter'],
        ];

        $page1Questions = [
            ['question_key' => 'industry', 'question' => 'What industry are you working in?', 'answer_type' => 'single_select', 'order' => 3, 'answer_option_key' => 'industry'],
            ['question_key' => 'location', 'question' => 'Where do you live?', 'answer_type' => 'single_select', 'order' => 4, 'answer_option_key' => 'country'],
            ['question_key' => 'church', 'question' => 'What church do you go to?', 'answer_type' => 'single_select', 'order' => 5, 'answer_option_key' => 'church'],
            ['question_key' => 'go_to_church', 'question' => 'Do you go to church every Sunday?', 'answer_type' => 'boolean', 'order' => 6],
            ['question_key' => 'married', 'question' => 'Have you been married?', 'answer_type' => 'boolean', 'order' => 7],
            ['question_key' => 'have_kids', 'question' => 'Do you have kids?', 'answer_type' => 'boolean', 'order' => 8],
            ['question_key' => 'birth_place', 'question' => 'Where were you born?', 'answer_type' => 'single_select', 'order' => 9, 'answer_option_key' => 'country'],
            ['question_key' => 'father_name', 'question' => 'What was your father\'s first and last name when he was born?', 'answer_type' => 'text', 'order' => 10],
            ['question_key' => 'mother_name', 'question' => 'What is your mother\'s first and last name?', 'answer_type' => 'text', 'order' => 11],
            ['question_key' => 'education', 'question' => 'What is your education level?', 'answer_type' => 'single_select', 'order' => 12, 'answer_option_key' => 'education'],
            ['question_key' => 'siblings', 'question' => 'How many siblings do you have?', 'answer_type' => 'numeric', 'order' => 13],
            ['question_key' => 'sports', 'question' => 'Do you play any sports?', 'answer_type' => 'boolean', 'order' => 14],
        ];

        $page2Questions = [
            ['question_key' => 'watch_sports', 'question' => 'Do you watch any sports?', 'answer_type' => 'boolean', 'order' => 1],
            ['question_key' => 'favorite_movie', 'question' => 'What’s your favorite movie?', 'answer_type' => 'multi_select', 'order' => 2, 'answer_option_key' => 'movie_genre'],
            ['question_key' => 'news_media', 'question' => 'What media do you watch for news?', 'answer_type' => 'multi_select', 'order' => 3, 'answer_option_key' => 'news_media'],
            ['question_key' => 'want_kids', 'question' => 'Do you like to have kids and build a family?', 'answer_type' => 'boolean', 'order' => 4],
            ['question_key' => 'ideal_place', 'question' => 'Where is your ideal place to live and raise a family?', 'answer_type' => 'multi_select', 'order' => 5, 'answer_option_key' => 'ideal_living_places'],
            ['question_key' => 'take_vacation', 'question' => 'Do you take a vacation?', 'answer_type' => 'boolean', 'order' => 6],
            ['question_key' => 'cook', 'question' => 'Do you cook?', 'question_aii' => 'ܡܒܫܠܬ ܐܢܬ؟', 'question_fa' => 'آیا آشپزی می‌کنید؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 7],
            ['question_key' => 'speak_assyrian', 'question' => 'Do you speak Assyrian in your household?', 'question_aii' => 'ܡܠܠܬ ܐܢܬ ܐܬܘܪܝܬ ܒܒܝܬܐ؟', 'question_fa' => 'آیا در خانه به زبان آشوری صحبت می‌کنید؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 8],
            ['question_key' => 'social_media_use', 'question' => 'What social media do you use?', 'question_aii' => 'ܡܢܝܢܐ ܫܡܫܬ ܒܕܟܝܬܐ ܚܒܪܝܬܐ؟', 'question_fa' => 'از چه شبکه اجتماعی استفاده می‌کنید؟', 'readonly' => false, 'answer_type' => 'multi_select', 'order' => 9, 'answer_option_key' => 'social_medias'],
        ];

        $page3Questions = [
            ['question_key' => 'read_write_assyrian', 'question' => 'Do you read and write Assyrian?', 'question_aii' => 'ܩܪܐ ܘܟܬܒܐ ܐܢܬ ܐܬܘܪܝܬ؟', 'question_fa' => 'آیا به زبان آشوری می‌خوانید و می‌نویسید؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 1],
            ['question_key' => 'play_music', 'question' => 'Do you play any music?', 'question_aii' => 'ܬܠܥ ܐܢܬ ܫܬܝܩܬܐ؟', 'question_fa' => 'آیا موسیقی می‌نوازید؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 2],
            ['question_key' => 'favorite_singer', 'question' => 'Who is your favorite Assyrian singer?', 'question_aii' => 'ܡܢ ܗܘ ܓܢܐܢܐ ܕܡܩܬܠܐ ܐܬܘܪܝܐ ܕܝܠܟ؟', 'question_fa' => 'خواننده آشوری مورد علاقه شما کیست؟', 'readonly' => false, 'answer_type' => 'multi_select', 'order' => 3, 'answer_option_key' => 'singers'],
            ['question_key' => 'favorite_food', 'question' => 'What is your favorite Assyrian food?', 'question_aii' => 'ܡܐ ܗܘܐ ܡܐܟܘܬܐ ܐܬܘܪܝܬܐ ܕܡܩܬܠܐ ܕܝܠܟ؟', 'question_fa' => 'غذای آشوری مورد علاقه شما چیست؟', 'readonly' => false, 'answer_type' => 'multi_select', 'order' => 4, 'answer_option_key' => 'foods'],
            ['question_key' => 'celebrate_holidays', 'question' => 'Do you celebrate all the holidays?', 'question_aii' => 'ܗܝܢ ܐܢܬ ܟܠܗ ܥܕܐ؟', 'question_fa' => 'آیا همه تعطیلات را جشن می‌گیرید؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 5],
            ['question_key' => 'preserve_heritage', 'question' => 'Is preserving the Assyrian heritage important to you?', 'question_aii' => 'ܗܘܐ ܠܟ ܚܫܝܚܐ ܕܢܛܪ ܬܘܪܝܬܐ ܕܐܬܘܪܝܐ؟', 'question_fa' => 'آیا حفظ میراث آشوری برای شما مهم است؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 6],
            ['question_key' => 'speak_assyrian_family', 'question' => 'If you start a family, will you speak Assyrian in your household and with your kids?', 'question_aii' => 'ܡܢ ܕܢܚܕܢ ܐܚܕܢܘܬܐ، ܡܠܠ ܐܢܬ ܐܬܘܪܝܬ ܒܒܝܬܐ ܘܥܡ ܝܠܕܝܟ؟', 'question_fa' => 'اگر خانواده تشکیل دهید، آیا در خانه و با فرزندانتان به زبان آشوری صحبت خواهید کرد؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 7],
            ['question_key' => 'like_art', 'question' => 'Do you like art?', 'question_aii' => 'ܨܒܐ ܐܢܬ ܠܐܘܡܢܘܬܐ؟', 'question_fa' => 'آیا به هنر علاقه دارید؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 8],
            ['question_key' => 'height', 'question' => 'How tall are you?', 'question_aii' => 'ܟܡܐ ܕܪܡܐ ܗܘܝܢ؟', 'question_fa' => 'قد شما چقدر است؟', 'readonly' => false, 'answer_type' => 'numeric', 'order' => 9],
            ['question_key' => 'move_for_love', 'question' => 'Are you willing to move for the love of your life to start a new life in a different city or country?', 'question_aii' => 'ܫܦܝܢ ܐܢܬ ܠܐܙܠܐ ܡܚܒܬܟ ܘܠܫܪܝܐ ܚܝܐ ܚܕܬܐ ܒܡܕܝܢܬܐ ܐܘ ܐܬܪܐ ܚܪܢܐ؟', 'question_fa' => 'آیا برای عشق زندگی‌تان مایلید به یک شهر یا کشور دیگر نقل مکان کنید و زندگی جدیدی شروع کنید؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 10],
            ['question_key' => 'live_with_parents', 'question' => 'Do you live with your parents?', 'question_aii' => 'ܕܐܝܬܝܗܘܢ ܒܝܬ ܐܒܘܗܝܟ؟', 'question_fa' => 'آیا با والدینتان زندگی می‌کنید؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 11],
            ['question_key' => 'parents_alive', 'question' => 'Are your parents still alive?', 'question_aii' => 'ܚܝܐ ܗܘܢ ܐܒܘܟ ܘܐܡܟ؟', 'question_fa' => 'آیا والدینتان هنوز زنده هستند؟', 'readonly' => false, 'answer_type' => 'boolean', 'order' => 12],
        ];
    }
}
