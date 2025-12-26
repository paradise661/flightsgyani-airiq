<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class BSPCommissionStoreRequest extends FormRequest
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
        if ($this->input('id')) {
            return [
                'airline' => 'required',
                'commission' => 'required'
            ];
        } else {
            return [
//                'airline' => 'required|unique:b_s_p_commissions,airline,id',
                'airline' => 'required',
                'commission' => 'required'
            ];
        }

    }

    public function messages()
    {
        return [
            'airline.required' => 'Airline is required.',
            'airline.unique' => 'Commission for this airline already exists.',
            'commission.required' => 'Commission value is required.'
        ];
    }
}
