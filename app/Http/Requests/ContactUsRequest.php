<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ReCaptchaV3;

class ContactUsRequest extends FormRequest
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
            'description' => 'required|min:3',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptchaV3('submitContact')]

        ];
    }
}
