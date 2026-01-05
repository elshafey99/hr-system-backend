<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warning extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'issued_by',
        'type',
        'reason',
        'issued_at',
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
            'issued_at' => 'datetime',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the employee who received this warning.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the admin who issued this warning.
     */
    public function issuer()
    {
        return $this->belongsTo(Admin::class, 'issued_by');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active warnings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include resolved warnings.
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Resolve the warning.
     *
     * @return bool
     */
    public function resolve(): bool
    {
        return $this->update(['status' => 'resolved']);
    }

    /**
     * Mark as objected.
     *
     * @return bool
     */
    public function object(): bool
    {
        return $this->update(['status' => 'objected']);
    }
}
