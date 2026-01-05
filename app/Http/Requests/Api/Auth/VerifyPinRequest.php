<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string'], // employee_number or email
            'pin' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
            'device_type' => ['nullable', 'in:android,ios,web'],
            'fcm_token' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'identifier.required' => 'Employee number or email is required',
            'pin.required' => 'PIN is required',
            'pin.size' => 'PIN must be exactly 4 digits',
            'pin.regex' => 'PIN must contain only numbers',
        ];
    }
}
