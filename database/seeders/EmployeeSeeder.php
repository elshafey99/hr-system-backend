<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'employee_number' => 'EMP001',
                'first_name' => 'محمد',
                'last_name' => 'أحمد',
                'email' => 'mohamed@company.com',
                'phone' => '+966501234567',
                'password' => 'password123', // Will be hashed automatically
                'pin' => '1234', // Will be hashed automatically
                'profile_image' => null,
                'gender' => 'male',
                'date_of_birth' => '1990-05-15',
                'marital_status' => 'married',
                'nationality_id' => 1,
                'department_id' => 1,
                'position_id' => 2,
                'project_id' => null,
                'manager_id' => null,
                'work_location_id' => 1,
                'work_schedule_id' => 1,
                'basic_salary' => 8500.00,
                'hire_date' => '2023-01-15',
                'status' => 'active',
            ],
            [
                'employee_number' => 'EMP002',
                'first_name' => 'فاطمة',
                'last_name' => 'علي',
                'email' => 'fatima@company.com',
                'phone' => '+966507654321',
                'password' => 'password123',
                'pin' => '5678',
                'profile_image' => null,
                'gender' => 'female',
                'date_of_birth' => '1992-08-20',
                'marital_status' => 'single',
                'nationality_id' => 1,
                'department_id' => 2,
                'position_id' => 4,
                'project_id' => null,
                'manager_id' => null,
                'work_location_id' => 1,
                'work_schedule_id' => 1,
                'basic_salary' => 7500.00,
                'hire_date' => '2023-03-10',
                'status' => 'active',
            ],
            [
                'employee_number' => 'EMP003',
                'first_name' => 'أحمد',
                'last_name' => 'خالد',
                'email' => 'ahmed@company.com',
                'phone' => '+966509876543',
                'password' => 'password123',
                'pin' => '9012',
                'profile_image' => null,
                'gender' => 'male',
                'date_of_birth' => '1988-12-05',
                'marital_status' => 'married',
                'nationality_id' => 2,
                'department_id' => 3,
                'position_id' => 3,
                'project_id' => null,
                'manager_id' => null,
                'work_location_id' => 2,
                'work_schedule_id' => 2,
                'basic_salary' => 9000.00,
                'hire_date' => '2022-06-01',
                'status' => 'active',
            ],
        ];

        foreach ($employees as $employeeData) {
            Employee::create($employeeData);
        }
    }
}
