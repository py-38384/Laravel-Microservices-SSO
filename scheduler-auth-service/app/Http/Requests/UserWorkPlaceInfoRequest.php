<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserWorkPlaceInfoRequest extends FormRequest
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
            'organization' => ['required', 'string', 'max:255'],
            'organization_size' => ['required', 'string', 'max:50'],
            'is_agency' => ['required', 'boolean'],
            'country' => ['required', 'string', 'max:100'],
            'time_zone' => ['required', 'string', 'max:50'],
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
