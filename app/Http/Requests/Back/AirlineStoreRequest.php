<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class AirlineStoreRequest extends FormRequest
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
            'code' => 'required|string',
            'image' => 'nullable|image|mimes:png|dimensions:width:500,height:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Airline name is required.',
            'code.required' => 'Airline IATA code is required.',
            'image.mimes' => 'Airline logo must be valid png file.',
            'image.dimensions' => 'Image must be of 500X500 px'
        ];
    }
}
