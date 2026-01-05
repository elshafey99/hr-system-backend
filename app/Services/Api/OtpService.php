<?php

namespace App\Services\Api;

use App\Models\Employee;
use App\Models\Otp;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Notification;

class OtpService
{
    /**
     * Generate OTP for employee
     *
     * @param Employee $employee
     * @param string $purpose
     * @return Otp
     */
    public function generate(Employee $employee, string $purpose = 'password_reset'): Otp
    {
        // Delete old OTPs for this employee and purpose
        Otp::where('employee_id', $employee->id)
            ->where('purpose', $purpose)
            ->where('is_used', false)
            ->delete();

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create new OTP
        $otp = Otp::create([
            'employee_id' => $employee->id,
            'code' => $code,
            'purpose' => $purpose,
            'expires_at' => now()->addMinutes(5),
            'is_used' => false,
        ]);

        return $otp;
    }

    /**
     * Send OTP via email
     *
     * @param Otp $otp
     * @return bool
     */
    public function send(Otp $otp): bool
    {
        try {
            $otp->employee->notify(new OtpNotification($otp));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify OTP code
     *
     * @param string $email
     * @param string $code
     * @param string $purpose
     * @return Otp|null
     */
    public function verify(string $email, string $code, string $purpose = 'password_reset'): ?Otp
    {
        $employee = Employee::where('email', $email)->first();

        if (!$employee) {
            return null;
        }

        return Otp::where('employee_id', $employee->id)
            ->where('code', $code)
            ->where('purpose', $purpose)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();
    }

    /**
     * Clean expired OTPs (can be called from a scheduled job)
     *
     * @return int Number of deleted OTPs
     */
    public function cleanExpired(): int
    {
        return Otp::where('expires_at', '<', now())
            ->orWhere('is_used', true)
            ->delete();
    }
}
