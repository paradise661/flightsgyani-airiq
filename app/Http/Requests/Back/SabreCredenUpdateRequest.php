<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class SabreCredenUpdateRequest extends FormRequest
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
            'sabrepcc' => 'required',
            'sabreurl' => 'required',
            'sabreuser' => 'required',
            'sabrepassword' => 'required',
            'sabrelniata' => 'required',
            'sabrecitycode' => 'required',
            'sabreaddressline' => 'required',
            'sabrecityname' => 'required',
            'sabrecountrycode' => 'required',
            'sabrepostal' => 'required',
            'sabrestreet' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'sabrepcc.required' => 'PCC can not be empty.',
            'sabreurl.required' => 'URL can not be empty.',
            'sabreuser.required' => 'Username can not be empty.',
            'sabrepassword.required' => 'Password is required.',
            'sabrelniata.required' => 'LNIATA is required.',
            'sabrecitycode.required' => 'City code is required.',
            'sabreaddressline.required' => 'Address is required.',
            'sabrecityname.required' => 'City name is required.',
            'sabrecountrycode.required' => 'Country code is required.',
            'sabrepostal.required' => 'Postal code is required.',
            'sabrestreet.required' => 'Street number is required.',
        ];
    }
}
