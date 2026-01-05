<?php

namespace App\Repositories\Api;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

class AuthRepository
{
    /**
     * Find employee by email
     *
     * @param string $email
     * @return Employee|null
     */
    public function findByEmail(string $email): ?Employee
    {
        return Employee::where('email', $email)->first();
    }

    /**
     * Find employee by employee number
     *
     * @param string $employeeNumber
     * @return Employee|null
     */
    public function findByEmployeeNumber(string $employeeNumber): ?Employee
    {
        return Employee::where('employee_number', $employeeNumber)->first();
    }

    /**
     * Find employee by identifier (email or employee_number)
     *
     * @param string $identifier
     * @return Employee|null
     */
    public function findByIdentifier(string $identifier): ?Employee
    {
        return Employee::where('employee_number', $identifier)
            ->orWhere('email', $identifier)
            ->first();
    }

    /**
     * Get employee with relationships
     *
     * @param int $employeeId
     * @param array $relations
     * @return Employee|null
     */
    public function getWithRelations(int $employeeId, array $relations = []): ?Employee
    {
        return Employee::with($relations)->find($employeeId);
    }

    /**
     * Update employee data
     *
     * @param Employee $employee
     * @param array $data
     * @return bool
     */
    public function update(Employee $employee, array $data): bool
    {
        return $employee->update($data);
    }

    /**
     * Create authentication token
     *
     * @param Employee $employee
     * @param string $tokenName
     * @return string
     */
    public function createToken(Employee $employee, string $tokenName = 'auth-token'): string
    {
        return $employee->createToken($tokenName)->plainTextToken;
    }

    /**
     * Revoke current token
     *
     * @param Employee $employee
     * @return void
     */
    public function revokeCurrentToken(Employee $employee): void
    {
        $employee->currentAccessToken()->delete();
    }

    /**
     * Revoke all tokens for employee
     *
     * @param Employee $employee
     * @return void
     */
    public function revokeAllTokens(Employee $employee): void
    {
        $employee->tokens()->delete();
    }
}
