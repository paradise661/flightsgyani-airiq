<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class AirportStoreRequest extends FormRequest
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
            'country' => 'required',
            'city' => 'required',
            'airport' => 'required',
            'code' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'country.required' => 'Country Name is required.',
            'city.required' => 'City Name is required',
            'airport.required' => 'Airport Name is required',
            'code.required' => 'IATA code is required'
        ];
    }
}
