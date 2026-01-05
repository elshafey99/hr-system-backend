<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'meeting_date',
        'start_time',
        'end_time',
        'location',
        'created_by',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meeting_date' => 'date',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the admin who created this meeting.
     */
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Get the meeting attendees.
     */
    public function attendees()
    {
        return $this->hasMany(MeetingAttendee::class);
    }

    /**
     * Get the employees attending this meeting.
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'meeting_attendees')
            ->withPivot('status', 'responded_at')
            ->withTimestamps();
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include scheduled meetings.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope a query to only include upcoming meetings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('meeting_date', '>=', now()->toDateString())
            ->where('status', 'scheduled');
    }

    /**
     * Scope a query to only include completed meetings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // ==================== HELPER METHODS ====================

    /**
     * Mark meeting as completed.
     *
     * @return bool
     */
    public function markAsCompleted(): bool
    {
        return $this->update(['status' => 'completed']);
    }

    /**
     * Cancel the meeting.
     *
     * @return bool
     */
    public function cancel(): bool
    {
        return $this->update(['status' => 'cancelled']);
    }

    /**
     * Get the meeting duration in minutes.
     *
     * @return int
     */
    public function getDurationAttribute(): int
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }
}
