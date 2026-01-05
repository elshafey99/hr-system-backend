<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'grace_period',
        'break_start',
        'break_end',
        'working_days',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'working_days' => 'array',
            'grace_period' => 'integer',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the employees with this schedule.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if today is a working day.
     *
     * @return bool
     */
    public function isWorkingDay(): bool
    {
        $dayOfWeek = now()->dayOfWeek;
        return in_array($dayOfWeek, $this->working_days ?? []);
    }

    /**
     * Check if a given time is late (after grace period).
     *
     * @param string $checkInTime
     * @return bool
     */
    public function isLate(string $checkInTime): bool
    {
        $scheduledStart = \Carbon\Carbon::parse($this->start_time);
        $actualCheckIn = \Carbon\Carbon::parse($checkInTime);
        $graceEnd = $scheduledStart->copy()->addMinutes($this->grace_period ?? 0);

        return $actualCheckIn->gt($graceEnd);
    }

    /**
     * Calculate delay in minutes.
     *
     * @param string $checkInTime
     * @return int
     */
    public function calculateDelayMinutes(string $checkInTime): int
    {
        $scheduledStart = \Carbon\Carbon::parse($this->start_time);
        $actualCheckIn = \Carbon\Carbon::parse($checkInTime);

        if ($actualCheckIn->lte($scheduledStart)) {
            return 0;
        }

        return $actualCheckIn->diffInMinutes($scheduledStart);
    }
}
