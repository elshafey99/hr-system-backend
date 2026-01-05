<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'radius',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'radius' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the employees at this location.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active locations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if coordinates are within this location's radius.
     *
     * @param float $lat
     * @param float $lng
     * @return bool
     */
    public function isWithinRadius(float $lat, float $lng): bool
    {
        if (!$this->latitude || !$this->longitude || !$this->radius) {
            return true; // No geofencing set
        }

        $distance = $this->calculateDistance($lat, $lng);
        return $distance <= $this->radius;
    }

    /**
     * Calculate distance in meters using Haversine formula.
     *
     * @param float $lat
     * @param float $lng
     * @return float
     */
    public function calculateDistance(float $lat, float $lng): float
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($lat);
        $lonTo = deg2rad($lng);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) ** 2 +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
