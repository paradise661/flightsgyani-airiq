<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class BranchStoreRequest extends FormRequest
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
            'title' => 'required',
            'location' => 'required|string',
            'email' => 'required',
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Branch title is required.',
            'location.required' => 'Branch location is required.',
            'email.required' => 'Branch email is required.',
            'phone.required' => 'Branch phone is required.'
        ];
    }
}
