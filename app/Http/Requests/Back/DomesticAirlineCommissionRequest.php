<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DomesticAirlineCommissionRequest extends FormRequest
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
            'domestic_airline_id' => [
                'required',
                Rule::unique('domestic_flight_commissions', 'domestic_airline_id')->ignore($this->route('commission')->id ?? null),
            ],
            // 'commission' => 'required|numeric',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'domestic_airline_id.unique' => 'The Airline has already been taken. Please Edit or Select Another Airline'
        ];
    }
}
