<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => ['ar' => 'تقنية المعلومات', 'en' => 'IT'], 'manager_id' => null, 'is_active' => true],
            ['name' => ['ar' => 'الموارد البشرية', 'en' => 'HR'], 'manager_id' => null, 'is_active' => true],
            ['name' => ['ar' => 'المحاسبة', 'en' => 'Accounting'], 'manager_id' => null, 'is_active' => true],
            ['name' => ['ar' => 'المبيعات', 'en' => 'Sales'], 'manager_id' => null, 'is_active' => true],
            ['name' => ['ar' => 'التسويق', 'en' => 'Marketing'], 'manager_id' => null, 'is_active' => true],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
