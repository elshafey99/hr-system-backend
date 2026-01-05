<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_salary',
        'total_earnings',
        'total_deductions',
        'net_salary',
        'status',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'month' => 'integer',
            'year' => 'integer',
            'basic_salary' => 'decimal:2',
            'total_earnings' => 'decimal:2',
            'total_deductions' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'published_at' => 'datetime',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the employee of this payslip.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include published payslips.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include draft payslips.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to filter by month and year.
     */
    public function scopeForPeriod($query, int $month, int $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Get the formatted period (e.g., "January 2024").
     *
     * @return string
     */
    public function getPeriodAttribute(): string
    {
        $date = \Carbon\Carbon::createFromDate($this->year, $this->month, 1);
        return $date->format('F Y');
    }

    /**
     * Publish the payslip.
     *
     * @return bool
     */
    public function publish(): bool
    {
        return $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Check if payslip is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
