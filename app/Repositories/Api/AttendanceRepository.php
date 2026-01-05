<?php

namespace App\Repositories\Api;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AttendanceRepository
{
    /**
     * Get today's attendance for employee
     *
     * @param int $employeeId
     * @return AttendanceRecord|null
     */
    public function getTodayAttendance(int $employeeId): ?AttendanceRecord
    {
        return AttendanceRecord::where('employee_id', $employeeId)
            ->whereDate('date', now()->toDateString())
            ->first();
    }

    /**
     * Create attendance record
     *
     * @param array $data
     * @return AttendanceRecord
     */
    public function create(array $data): AttendanceRecord
    {
        return AttendanceRecord::create($data);
    }

    /**
     * Update attendance record
     *
     * @param AttendanceRecord $attendance
     * @param array $data
     * @return bool
     */
    public function update(AttendanceRecord $attendance, array $data): bool
    {
        return $attendance->update($data);
    }

    /**
     * Get attendance history with filters
     *
     * @param int $employeeId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getHistory(int $employeeId, array $filters = []): LengthAwarePaginator
    {
        $query = AttendanceRecord::where('employee_id', $employeeId);

        // Date range filter
        if (!empty($filters['from_date'])) {
            $query->whereDate('date', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('date', '<=', $filters['to_date']);
        }

        // Status filter
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('date', 'desc')
            ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get attendance records for statistics
     *
     * @param int $employeeId
     * @param int $month
     * @param int $year
     * @return Collection
     */
    public function getForStatistics(int $employeeId, int $month, int $year): Collection
    {
        return AttendanceRecord::where('employee_id', $employeeId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();
    }

    /**
     * Check if employee has checked in today
     *
     * @param int $employeeId
     * @return bool
     */
    public function hasCheckedInToday(int $employeeId): bool
    {
        return AttendanceRecord::where('employee_id', $employeeId)
            ->whereDate('date', now()->toDateString())
            ->whereNotNull('check_in_time')
            ->exists();
    }

    /**
     * Check if employee has checked out today
     *
     * @param int $employeeId
     * @return bool
     */
    public function hasCheckedOutToday(int $employeeId): bool
    {
        return AttendanceRecord::where('employee_id', $employeeId)
            ->whereDate('date', now()->toDateString())
            ->whereNotNull('check_out_time')
            ->exists();
    }
}
