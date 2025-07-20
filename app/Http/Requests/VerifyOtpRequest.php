<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyOtpRequest extends FormRequest
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
            'phone_number' => ['required', 'regex:/^09\d{9}$/'],
            'otp' => ['required', 'digits:6']
        ];
    }
    public function messages(): array
    {
        return [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex' => 'Phone number is not valid (e.g., 09123456789).',
            'otp.required' => 'OTP code is required.',
            'otp.digits' => 'OTP code must be exactly 6 digits.'
        ];
    }
    public function failedValidation(ValidationValidator $validation)
    {
        $response = response()->json([
            'statusCode' => 422,
            'message' => 'Validation failed',
            'errors' => $validation->errors()
        ]);
        throw new HttpResponseException($response);
    }
}
