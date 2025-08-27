<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInterestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'interest_type' => ['required', 'string', 'max:255'],
            'interests' => ['required', 'array'],
            'interests.*' => ['string'],
        ];
    }


    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'data' => null
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}