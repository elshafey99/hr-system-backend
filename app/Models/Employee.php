<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'pin',
        'profile_image',
        'gender',
        'date_of_birth',
        'marital_status',
        'nationality_id',
        'department_id',
        'position_id',
        'project_id',
        'manager_id',
        'work_location_id',
        'work_schedule_id',
        'basic_salary',
        'hire_date',
        'status',
        'email_verified_at',
        'phone_verified_at',
        'last_login_at',
        'fcm_token',
        'device_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'pin',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'hire_date' => 'date',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'pin' => 'hashed',
            'basic_salary' => 'decimal:2',
        ];
    }

    /**
     * Get the employee's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the nationality of the employee.
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    /**
     * Get the department of the employee.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the position of the employee.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the project of the employee.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the manager of the employee.
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Get the employees managed by this employee.
     */
    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    /**
     * Get the work location of the employee.
     */
    public function workLocation()
    {
        return $this->belongsTo(WorkLocation::class);
    }

    /**
     * Get the work schedule of the employee.
     */
    public function workSchedule()
    {
        return $this->belongsTo(WorkSchedule::class);
    }

    /**
     * Get the attendance records of the employee.
     */
    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    /**
     * Get the requests of the employee.
     */
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    /**
     * Get the payslips of the employee.
     */
    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    /**
     * Get the warnings of the employee.
     */
    public function warnings()
    {
        return $this->hasMany(Warning::class);
    }

    /**
     * Get the notifications of the employee.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the OTPs of the employee.
     */
    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    /**
     * Get the documents of the employee.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the contracts of the employee.
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the meetings the employee is attending.
     */
    public function meetingAttendances()
    {
        return $this->hasMany(MeetingAttendee::class);
    }

    /**
     * Get the meetings through meeting attendees.
     */
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_attendees')
            ->withPivot('status', 'responded_at')
            ->withTimestamps();
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active employees.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include terminated employees.
     */
    public function scopeTerminated($query)
    {
        return $query->where('status', 'terminated');
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if employee is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get today's attendance record.
     */
    public function getTodayAttendance()
    {
        return $this->attendanceRecords()
            ->whereDate('date', now()->toDateString())
            ->first();
    }

    /**
     * Get the active contract.
     */
    public function getActiveContract()
    {
        return $this->contracts()
            ->where('status', 'active')
            ->latest()
            ->first();
    }
}
