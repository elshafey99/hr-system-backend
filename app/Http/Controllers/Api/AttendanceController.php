<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Attendance\CheckInRequest;
use App\Http\Requests\Api\Attendance\CheckOutRequest;
use App\Http\Requests\Api\Attendance\AttendanceHistoryRequest;
use App\Http\Requests\Api\Attendance\AttendanceStatisticsRequest;
use App\Http\Resources\AttendanceResource;
use App\Services\Api\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Check-in
     *
     * @param CheckInRequest $request
     * @return JsonResponse
     */
    public function checkIn(CheckInRequest $request): JsonResponse
    {
        /** @var \App\Models\Employee $employee */
        $employee = Auth::user();
        $employee->load('workLocation', 'workSchedule');

        $result = $this->attendanceService->checkIn(
            $employee,
            $request->latitude,
            $request->longitude,
            $request->notes
        );

        if (!$result['success']) {
            return ApiResponse::sendResponse(400, $result['message'], $result['distance'] ?? null);
        }

        return ApiResponse::sendResponse(200, 'Checked in successfully', [
            'attendance' => new AttendanceResource($result['attendance'])
        ]);
    }

    /**
     * Check-out
     *
     * @param CheckOutRequest $request
     * @return JsonResponse
     */
    public function checkOut(CheckOutRequest $request): JsonResponse
    {
        /** @var \App\Models\Employee $employee */
        $employee = Auth::user();
        $employee->load('workSchedule');

        $result = $this->attendanceService->checkOut(
            $employee,
            $request->latitude,
            $request->longitude,
            $request->notes
        );

        if (!$result['success']) {
            return ApiResponse::sendResponse(400, $result['message']);
        }

        return ApiResponse::sendResponse(200, 'Checked out successfully', [
            'attendance' => new AttendanceResource($result['attendance'])
        ]);
    }

    /**
     * Get today's attendance
     *
     * @return JsonResponse
     */
    public function today(): JsonResponse
    {
        /** @var \App\Models\Employee $employee */
        $employee = Auth::user();

        $attendance = $this->attendanceService->getTodayAttendance($employee->id);

        if (!$attendance) {
            return ApiResponse::sendResponse(404, 'No attendance record found for today');
        }

        return ApiResponse::sendResponse(200, null, [
            'attendance' => new AttendanceResource($attendance)
        ]);
    }

    /**
     * Get attendance history
     *
     * @param AttendanceHistoryRequest $request
     * @return JsonResponse
     */
    public function history(AttendanceHistoryRequest $request): JsonResponse
    {
        /** @var \App\Models\Employee $employee */
        $employee = Auth::user();

        $filters = $request->only(['from_date', 'to_date', 'status', 'per_page']);
        $history = $this->attendanceService->getHistory($employee->id, $filters);

        return ApiResponse::sendResponse(200, null, [
            'attendance' => AttendanceResource::collection($history->items()),
            'pagination' => [
                'current_page' => $history->currentPage(),
                'total' => $history->total(),
                'per_page' => $history->perPage(),
                'last_page' => $history->lastPage(),
            ]
        ]);
    }

    /**
     * Get attendance statistics
     *
     * @param AttendanceStatisticsRequest $request
     * @return JsonResponse
     */
    public function statistics(AttendanceStatisticsRequest $request): JsonResponse
    {
        /** @var \App\Models\Employee $employee */
        $employee = Auth::user();

        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $statistics = $this->attendanceService->getStatistics($employee->id, $month, $year);

        return ApiResponse::sendResponse(200, null, [
            'statistics' => $statistics
        ]);
    }
}
