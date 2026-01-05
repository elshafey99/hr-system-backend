<?php

namespace Database\Seeders;

use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;

class WorkScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'name' => 'Morning Shift',
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'grace_period' => 15,
                'break_start' => '12:00:00',
                'break_end' => '13:00:00',
                'working_days' => [0, 1, 2, 3, 4], // Sunday to Thursday
            ],
            [
                'name' => 'Evening Shift',
                'start_time' => '14:00:00',
                'end_time' => '22:00:00',
                'grace_period' => 10,
                'break_start' => '18:00:00',
                'break_end' => '19:00:00',
                'working_days' => [0, 1, 2, 3, 4],
            ],
        ];

        foreach ($schedules as $schedule) {
            WorkSchedule::create($schedule);
        }
    }
}
