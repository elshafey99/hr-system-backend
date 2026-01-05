<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SetupPinRequest extends FormRequest
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
            'pin' => ['required', 'string', 'size:4', 'confirmed', 'regex:/^[0-9]{4}$/'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'pin.required' => 'PIN is required',
            'pin.size' => 'PIN must be exactly 4 digits',
            'pin.confirmed' => 'PIN confirmation does not match',
            'pin.regex' => 'PIN must contain only numbers',
        ];
    }
}
