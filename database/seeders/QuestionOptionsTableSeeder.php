<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionOption;

class QuestionOptionsTableSeeder extends Seeder
{
    public function run()
    {
        $countries = [
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

        $options = [
            'industry' => ['Medicine', 'Computer & Technology', 'Education', 'Finance', 'Real Estate', 'Accounting', 'Marketing', 'Other'],
            'church' => ['Church of the East', 'The Ancient Church of the East', 'Protestant', 'Catholic', 'Other'],
            'education' => ['Ph.D. Degree', 'Master Degree', 'Bachelor Degree', 'Associate Degree', 'Other'],
            'movie_genre' => ['Action', 'Drama', 'Comedy', 'Horror', 'Sci-Fi', 'Classics', 'Faith', 'Family Movies', 'Romance', 'Other'],
            'news_media' => ['CNN', 'BBC', 'Fox News', 'NBC', 'CBS', 'Newspaper', 'Other'],
            'social_medias' => ['Facebook', 'Instagram', 'WhatsApp', 'TikTok', 'Telegram', 'Pinterest', 'Skype', 'Viber', 'Discord', 'Tumblr', 'Twitter'],
            'singers' => ['Linda George', 'Juliana Jendo', 'Sargon Gabriel', 'Ashur Bet Sargis', 'Evin Aghassi', 'Other'],
            'foods' => ['Booshala', 'Kipteh', 'Dolmeh', 'Biryani', 'Kubba', 'Other'],
        ];

        // اضافه کردن گزینه‌های کشور برای سوالات مرتبط
        foreach (['country_live', 'country_born'] as $questionKey) {
            $question = Question::where('question_key', $questionKey)->first();
            if ($question) {
                foreach ($countries as $country) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'question_key' => $questionKey,
                        'option_value' => $country,
                    ]);
                }
            }
        }

        // اضافه کردن گزینه‌های مشخص‌شده
        foreach ($options as $questionKey => $values) {
            $question = Question::where('question_key', $questionKey)->first();
            if ($question) {
                foreach ($values as $value) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'question_key' => $questionKey,
                        'option_value' => $value,
                    ]);
                }
            }
        }
    }
}
