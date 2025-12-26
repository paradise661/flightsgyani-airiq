<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceDetailsRequest extends FormRequest
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
            'adult_single_share' => 'required',
            'adult_double_share' => 'required',
            'adult_trip_share' => 'required',
            'child_with_bed' => 'required',
            'child_without_bed' => 'required',
            'infant' => 'required',

        ];
    }
}
