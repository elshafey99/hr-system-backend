<?php

namespace App\Services\Api;

use App\Models\Employee;
use App\Repositories\Api\AuthRepository;
use App\Services\Api\OtpService;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $authRepository;
    protected $otpService;

    public function __construct(AuthRepository $authRepository, OtpService $otpService)
    {
        $this->authRepository = $authRepository;
        $this->otpService = $otpService;
    }

    /**
     * Attempt to login employee with email and password
     *
     * @param string $email
     * @param string $password
     * @return array|null Returns employee and token on success, null on failure
     */
    public function attemptLogin(string $email, string $password): ?array
    {
        $employee = $this->authRepository->findByEmail($email);

        if (!$employee || !Hash::check($password, $employee->password)) {
            return null;
        }

        if ($employee->status !== 'active') {
            return ['error' => 'inactive', 'message' => 'Your account is not active. Please contact HR.'];
        }

        return ['employee' => $employee];
    }

    /**
     * Attempt to login with PIN
     *
     * @param string $identifier
     * @param string $pin
     * @return array|null
     */
    public function attemptPinLogin(string $identifier, string $pin): ?array
    {
        $employee = $this->authRepository->findByIdentifier($identifier);

        if (!$employee || !Hash::check($pin, $employee->pin)) {
            return null;
        }

        if ($employee->status !== 'active') {
            return ['error' => 'inactive', 'message' => 'Your account is not active. Please contact HR.'];
        }

        return ['employee' => $employee];
    }

    /**
     * Update device information
     *
     * @param Employee $employee
     * @param string|null $deviceType
     * @param string|null $fcmToken
     * @return void
     */
    public function updateDeviceInfo(Employee $employee, ?string $deviceType, ?string $fcmToken): void
    {
        $this->authRepository->update($employee, [
            'device_type' => $deviceType,
            'fcm_token' => $fcmToken,
            'last_login_at' => now(),
        ]);
    }

    /**
     * Create authentication token
     *
     * @param Employee $employee
     * @return string
     */
    public function createToken(Employee $employee): string
    {
        return $this->authRepository->createToken($employee);
    }

    /**
     * Logout employee (revoke current token)
     *
     * @param Employee $employee
     * @return void
     */
    public function logout(Employee $employee): void
    {
        $this->authRepository->revokeCurrentToken($employee);
    }

    /**
     * Get employee profile with relationships
     *
     * @param int $employeeId
     * @return Employee|null
     */
    public function getProfile(int $employeeId): ?Employee
    {
        return $this->authRepository->getWithRelations($employeeId, [
            'nationality',
            'department',
            'position',
            'project',
            'manager',
            'workLocation',
            'workSchedule'
        ]);
    }

    /**
     * Send password reset OTP
     *
     * @param string $email
     * @return array|null Returns OTP info on success, null if employee not found
     */
    public function sendPasswordResetOtp(string $email): ?array
    {
        $employee = $this->authRepository->findByEmail($email);

        if (!$employee) {
            return null;
        }

        $otp = $this->otpService->generate($employee, 'password_reset');
        $this->otpService->send($otp);

        return ['expires_in' => 300]; // 5 minutes
    }

    /**
     * Verify OTP code
     *
     * @param string $email
     * @param string $code
     * @return string|null Returns reset token on success, null on failure
     */
    public function verifyPasswordResetOtp(string $email, string $code): ?string
    {
        $otp = $this->otpService->verify($email, $code, 'password_reset');

        if (!$otp) {
            return null;
        }

        // Mark OTP as used
        $otp->markAsUsed();

        // Generate temporary reset token
        return base64_encode($otp->employee->email . '|' . now()->timestamp);
    }

    /**
     * Reset password with reset token
     *
     * @param string $resetToken
     * @param string $newPassword
     * @return array Returns success status and optional error message
     */
    public function resetPassword(string $resetToken, string $newPassword): array
    {
        // Decode reset token
        $decoded = base64_decode($resetToken);
        $parts = explode('|', $decoded);

        if (count($parts) !== 2) {
            return ['success' => false, 'message' => 'Invalid reset token'];
        }

        [$email, $timestamp] = $parts;

        // Check if token is still valid (15 minutes)
        if (now()->timestamp - $timestamp > 900) {
            return ['success' => false, 'message' => 'Reset token has expired'];
        }

        $employee = $this->authRepository->findByEmail($email);

        if (!$employee) {
            return ['success' => false, 'message' => 'Invalid reset token'];
        }

        // Update password
        $this->authRepository->update($employee, [
            'password' => $newPassword
        ]);

        return ['success' => true];
    }

    /**
     * Setup PIN for employee
     *
     * @param Employee $employee
     * @param string $pin
     * @return void
     */
    public function setupPin(Employee $employee, string $pin): void
    {
        $this->authRepository->update($employee, [
            'pin' => $pin
        ]);
    }
}
