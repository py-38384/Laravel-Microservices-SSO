<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSocialAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            '*.title' => ['required', 'string', 'max:255'],
            '*.pages' => ['required', 'array'],
            '*.pages.*' => ['string'],
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
