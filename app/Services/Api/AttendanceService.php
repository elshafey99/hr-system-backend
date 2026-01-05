<?php

namespace App\Services\Api;

use App\Models\Employee;
use App\Models\AttendanceRecord;
use App\Repositories\Api\AttendanceRepository;
use Carbon\Carbon;

class AttendanceService
{
    protected $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    /**
     * Process check-in
     *
     * @param Employee $employee
     * @param float $latitude
     * @param float $longitude
     * @param string|null $notes
     * @return array
     */
    public function checkIn(Employee $employee, float $latitude, float $longitude, ?string $notes = null): array
    {
        // Check if already checked in today
        if ($this->attendanceRepository->hasCheckedInToday($employee->id)) {
            return [
                'success' => false,
                'message' => 'You have already checked in today'
            ];
        }

        // Validate location if employee has assigned work location
        if ($employee->workLocation) {
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $employee->workLocation->latitude,
                $employee->workLocation->longitude
            );

            if ($distance > $employee->workLocation->radius) {
                return [
                    'success' => false,
                    'message' => 'You are outside the allowed work location radius',
                    'distance' => round($distance, 2)
                ];
            }
        }

        $now = Carbon::now();
        $isLate = false;
        $delayMinutes = 0;

        // Check lateness if employee has work schedule
        if ($employee->workSchedule) {
            $scheduleStart = Carbon::parse($employee->workSchedule->start_time);
            $gracePeriod = $employee->workSchedule->grace_period ?? 0;
            
            $allowedTime = $scheduleStart->copy()->addMinutes($gracePeriod);
            
            if ($now->gt($allowedTime)) {
                $isLate = true;
                $delayMinutes = $now->diffInMinutes($scheduleStart);
            }
        }

        // Create attendance record
        $attendance = $this->attendanceRepository->create([
            'employee_id' => $employee->id,
            'date' => $now->toDateString(),
            'check_in_time' => $now->toTimeString(),
            'check_in_lat' => $latitude,
            'check_in_lng' => $longitude,
            'is_late' => $isLate,
            'delay_minutes' => $delayMinutes,
            'status' => 'present',
            'notes' => $notes,
        ]);

        return [
            'success' => true,
            'attendance' => $attendance
        ];
    }

    /**
     * Process check-out
     *
     * @param Employee $employee
     * @param float $latitude
     * @param float $longitude
     * @param string|null $notes
     * @return array
     */
    public function checkOut(Employee $employee, float $latitude, float $longitude, ?string $notes = null): array
    {
        // Get today's attendance
        $attendance = $this->attendanceRepository->getTodayAttendance($employee->id);

        if (!$attendance) {
            return [
                'success' => false,
                'message' => 'You need to check in first'
            ];
        }

        if ($attendance->check_out_time) {
            return [
                'success' => false,
                'message' => 'You have already checked out today'
            ];
        }

        $now = Carbon::now();
        $checkInTime = Carbon::parse($attendance->check_in_time);
        
        // Calculate working hours
        $totalMinutes = $now->diffInMinutes($checkInTime);
        
        // Subtract break time if exists
        if ($employee->workSchedule && $employee->workSchedule->break_start && $employee->workSchedule->break_end) {
            $breakStart = Carbon::parse($employee->workSchedule->break_start);
            $breakEnd = Carbon::parse($employee->workSchedule->break_end);
            $breakMinutes = $breakEnd->diffInMinutes($breakStart);
            $totalMinutes -= $breakMinutes;
        }
        
        $totalHours = round($totalMinutes / 60, 2);
        
        // Calculate overtime
        $overtimeHours = 0;
        if ($employee->workSchedule) {
            $scheduleStart = Carbon::parse($employee->workSchedule->start_time);
            $scheduleEnd = Carbon::parse($employee->workSchedule->end_time);
            $scheduledHours = $scheduleEnd->diffInHours($scheduleStart);
            
            if ($totalHours > $scheduledHours) {
                $overtimeHours = round($totalHours - $scheduledHours, 2);
            }
        }

        // Update attendance record
        $this->attendanceRepository->update($attendance, [
            'check_out_time' => $now->toTimeString(),
            'check_out_lat' => $latitude,
            'check_out_lng' => $longitude,
            'total_hours' => $totalHours,
            'overtime_hours' => $overtimeHours,
            'notes' => $notes ? $attendance->notes . ' | ' . $notes : $attendance->notes,
        ]);

        return [
            'success' => true,
            'attendance' => $attendance->fresh()
        ];
    }

    /**
     * Get today's attendance
     *
     * @param int $employeeId
     * @return AttendanceRecord|null
     */
    public function getTodayAttendance(int $employeeId): ?AttendanceRecord
    {
        return $this->attendanceRepository->getTodayAttendance($employeeId);
    }

    /**
     * Get attendance history
     *
     * @param int $employeeId
     * @param array $filters
     * @return mixed
     */
    public function getHistory(int $employeeId, array $filters = [])
    {
        return $this->attendanceRepository->getHistory($employeeId, $filters);
    }

    /**
     * Get attendance statistics
     *
     * @param int $employeeId
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getStatistics(int $employeeId, int $month, int $year): array
    {
        $records = $this->attendanceRepository->getForStatistics($employeeId, $month, $year);

        $totalDays = $records->count();
        $presentDays = $records->where('status', 'present')->count();
        $absentDays = $records->where('status', 'absent')->count();
        $leaveDays = $records->where('status', 'leave')->count();
        $lateDays = $records->where('is_late', true)->count();
        
        $totalHours = $records->sum('total_hours');
        $overtimeHours = $records->sum('overtime_hours');
        
        // Calculate average check-in time
        $checkInTimes = $records->whereNotNull('check_in_time')->pluck('check_in_time');
        $averageCheckIn = null;
        
        if ($checkInTimes->count() > 0) {
            $totalSeconds = $checkInTimes->map(function ($time) {
                return Carbon::parse($time)->secondsSinceMidnight();
            })->sum();
            
            $avgSeconds = $totalSeconds / $checkInTimes->count();
            $averageCheckIn = gmdate('H:i:s', $avgSeconds);
        }

        $onTimePercentage = $presentDays > 0 
            ? round((($presentDays - $lateDays) / $presentDays) * 100, 2) 
            : 0;

        return [
            'total_days' => $totalDays,
            'present_days' => $presentDays,
            'absent_days' => $absentDays,
            'leave_days' => $leaveDays,
            'late_days' => $lateDays,
            'total_hours' => $totalHours,
            'overtime_hours' => $overtimeHours,
            'average_check_in' => $averageCheckIn,
            'on_time_percentage' => $onTimePercentage,
        ];
    }

    /**
     * Calculate distance between two GPS coordinates using Haversine formula
     *
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float Distance in meters
     */
    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
