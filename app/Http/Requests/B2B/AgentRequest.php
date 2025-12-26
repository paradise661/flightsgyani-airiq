<?php

namespace App\Http\Requests\B2B;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgentRequest extends FormRequest
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
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->route('agent')->id ?? null),
            ],
            'address' => 'required',
            'pan_vat_number' => 'required',
            'phonenumber' => 'required',
            'contact_person' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Agency name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Provide a valid email.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password is too weak.',
            'password.min' => 'Password must be longer than 6 characters.',
            'address.required' => 'Agency address is required.',
            'pan_vat_number.required' => 'Agency PAN/VAT Number is required.',
            'phonenumber.required' => 'Agency contact number is required.',
            'contact_person.required' => 'Agency contact person is required.'
        ];
    }
}
