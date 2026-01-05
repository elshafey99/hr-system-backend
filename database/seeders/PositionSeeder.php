<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => ['ar' => 'مدير', 'en' => 'Manager']],
            ['name' => ['ar' => 'مهندس برمجيات', 'en' => 'Software Engineer']],
            ['name' => ['ar' => 'محاسب', 'en' => 'Accountant']],
            ['name' => ['ar' => 'موظف موارد بشرية', 'en' => 'HR Officer']],
            ['name' => ['ar' => 'مصمم جرافيك', 'en' => 'Graphic Designer']],
            ['name' => ['ar' => 'موظف مبيعات', 'en' => 'Sales Representative']],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
