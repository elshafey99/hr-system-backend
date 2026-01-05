<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Admin seeders
            RoleSeeder::class,
            AdminSeeder::class,
            SettingsSeeder::class,
            
            // HR System Lookup Tables (must be before EmployeeSeeder)
            NationalitySeeder::class,
            PositionSeeder::class,
            DepartmentSeeder::class,
            WorkLocationSeeder::class,
            WorkScheduleSeeder::class,
            
            // HR System Employees
            EmployeeSeeder::class,
        ]);
    }
}
