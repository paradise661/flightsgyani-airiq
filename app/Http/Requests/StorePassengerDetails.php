<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassengerDetails extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'emergency_full_name' => 'required|string',
            'emergency_phone_number' => 'required',
            'emergency_email' => 'required',
            'adult_first_name' => 'array',
            'adult_first_name.*' => 'required',
            'adult_last_name' => 'array',
            'adult_last_name.*' => 'required',
            'child_first_name' => 'array',
            'child_first_name.*' => 'required',
            'child_last_name' => 'array',
            'child_last_name.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'emergency_full_name.required' => 'The full name field is required.',
            'emergency_full_name.string' => 'The full name must be a valid string.',
            'emergency_phone_number.required' => 'The phone number field is required.',
            'emergency_email.required' => 'The email field is required.',
            'adult_first_name.*.required' => 'The first name field is required.',
            'adult_last_name.*.required' => 'The last name field is required.',
            'child_first_name.*.required' => 'The first name field is required.',
            'child_last_name.*.required' => 'The last name field is required.',
        ];
    }
}
