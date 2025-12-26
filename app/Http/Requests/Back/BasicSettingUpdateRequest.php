<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class BasicSettingUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'hunting_line' => 'required',
            'contactemail' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required.',
            'address.required' => 'Address is required.',
            'phone.required' => 'Provide all available contact address.',
            'email.required' => 'Provide all available email addresses.',
            'hunting_line.required' => 'Provide main contact address.',
            'contactemail.required' => 'Provide main contact email.'
        ];
    }
}
