<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class DomesticCredentialUpdateRequest extends FormRequest
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
            'userid' => 'required',
            'password' => 'required',
            'agency' => 'required',
            'url' => 'required|url'
        ];
    }

    public function messages()
    {
        return [
            'userid.required' => 'User ID is required.',
            'password.required' => 'Password is required.',
            'agency.required' => 'Agency Code is required.',
            'url.required' => 'URL is required.',
            'url.url' => 'Enter a valid URL.'
        ];
    }
}
