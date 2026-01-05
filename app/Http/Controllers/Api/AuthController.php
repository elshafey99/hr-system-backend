<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\VerifyOtpRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\SetupPinRequest;
use App\Http\Requests\Api\Auth\VerifyPinRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\Api\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login with email and password
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->attemptLogin($request->email, $request->password);

        if (!$result) {
            return ApiResponse::sendResponse(401, 'Invalid credentials');
        }

        if (isset($result['error']) && $result['error'] === 'inactive') {
            return ApiResponse::sendResponse(403, $result['message']);
        }

        $employee = $result['employee'];

        // Update device info and create token
        $this->authService->updateDeviceInfo($employee, $request->device_type, $request->fcm_token);
        $token = $this->authService->createToken($employee);

        return ApiResponse::sendResponse(200, 'Login successful', [
            'employee' => new EmployeeResource($employee),
            'token' => $token,
        ]);
    }

    /**
     * Logout (revoke current token)
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        /** @var \App\Models\Employee $employee */
        $employee = Auth::user();
        $this->authService->logout($employee);

        return ApiResponse::sendResponse(200, 'Logged out successfully');
    }

    /**
     * Get current authenticated employee
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        /** @var \App\Models\Employee $employee */
        $employee = Auth::user();
        $employeeWithRelations = $this->authService->getProfile($employee->id);

        return ApiResponse::sendResponse(200, null, [
            'employee' => new EmployeeResource($employeeWithRelations)
        ]);
    }

    /**
     * Send OTP to email for password reset
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->authService->sendPasswordResetOtp($request->email);

        if (!$result) {
            return ApiResponse::sendResponse(404, 'No account found with this email');
        }

        return ApiResponse::sendResponse(200, 'OTP sent to your email', $result);
    }

    /**
     * Verify OTP code
     *
     * @param VerifyOtpRequest $request
     * @return JsonResponse
     */
    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $resetToken = $this->authService->verifyPasswordResetOtp($request->email, $request->code);

        if (!$resetToken) {
            return ApiResponse::sendResponse(400, 'Invalid or expired OTP');
        }

        return ApiResponse::sendResponse(200, 'OTP verified successfully', [
            'reset_token' => $resetToken
        ]);
    }

    /**
     * Reset password with reset token
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $result = $this->authService->resetPassword($request->reset_token, $request->password);

        if (!$result['success']) {
            return ApiResponse::sendResponse(400, $result['message']);
        }

        return ApiResponse::sendResponse(200, 'Password reset successfully');
    }

    /**
     * Setup PIN for quick login
     *
     * @param SetupPinRequest $request
     * @return JsonResponse
     */
    public function setupPin(SetupPinRequest $request): JsonResponse
    {
        /** @var \App\Models\Employee $employee */
        $employee = Auth::user();
        $this->authService->setupPin($employee, $request->pin);

        return ApiResponse::sendResponse(200, 'PIN setup successfully');
    }

    /**
     * Login with PIN (quick login)
     *
     * @param VerifyPinRequest $request
     * @return JsonResponse
     */
    public function verifyPin(VerifyPinRequest $request): JsonResponse
    {
        $result = $this->authService->attemptPinLogin($request->identifier, $request->pin);

        if (!$result) {
            return ApiResponse::sendResponse(401, 'Invalid PIN or employee number');
        }

        if (isset($result['error']) && $result['error'] === 'inactive') {
            return ApiResponse::sendResponse(403, $result['message']);
        }

        $employee = $result['employee'];

        // Update device info and create token
        $this->authService->updateDeviceInfo($employee, $request->device_type, $request->fcm_token);
        $token = $this->authService->createToken($employee);

        return ApiResponse::sendResponse(200, 'Login successful', [
            'employee' => new EmployeeResource($employee),
            'token' => $token,
        ]);
    }
}
