<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreInquiryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255'
            ],
            'email' => [
                'required',
                'email:rfc,dns',  // Validates format AND checks if domain exists
                'max:255'
            ],
            'category' => [
                'required',
                'string',
                'in:trading,market_data,technical_issues,general'
            ],
            'subject' => [
                'required',
                'string',
                'min:5',
                'max:255'
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:5000'
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
    throw new HttpResponseException(
        response()->json([
            'success' => false,
            'message' => 'Validation failed. Please check your input.',
            'errors' => $validator->errors()
        ], 422)
    );
    }
}
