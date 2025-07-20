<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendOTPRequest extends FormRequest
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
        ];
    }
    public function messages(): array
    {
        return [
            'phone_number.required' => 'Phone number is required',
            'phone_number.regex' => 'Phone number must be a valid Iranian mobile number starting with 09',
        ];
    }
    public function failedValidation(Validator $validation)
    {
        $response = response()->json([
            'statusCode' => 422,
            'message' => 'Validation failed',
            'errors' => $validation->errors()
        ]);
        throw new HttpResponseException($response);
    }
}
