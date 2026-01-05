<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationalities = [
            ['name' => ['ar' => 'سعودي', 'en' => 'Saudi'], 'country_code' => 'SA', 'is_active' => true],
            ['name' => ['ar' => 'مصري', 'en' => 'Egyptian'], 'country_code' => 'EG', 'is_active' => true],
            ['name' => ['ar' => 'أردني', 'en' => 'Jordanian'], 'country_code' => 'JO', 'is_active' => true],
            ['name' => ['ar' => 'إماراتي', 'en' => 'Emirati'], 'country_code' => 'AE', 'is_active' => true],
            ['name' => ['ar' => 'كويتي', 'en' => 'Kuwaiti'], 'country_code' => 'KW', 'is_active' => true],
            ['name' => ['ar' => 'قطري', 'en' => 'Qatari'], 'country_code' => 'QA', 'is_active' => true],
        ];

        foreach ($nationalities as $nationality) {
            Nationality::create($nationality);
        }
    }
}
