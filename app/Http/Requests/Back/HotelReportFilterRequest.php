<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class HotelReportFilterRequest extends FormRequest
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
            'from_date' => 'nullable|date|date_format:d-m-Y',
            'to_date' => 'nullable|date|date_format:d-m-Y',
            'currency' => 'in:All,NPR,USD',
            'rating' => 'nullable|in:2,3,4,5',
            'hotel' => 'nullable|exists:hotels,slug'
        ];
    }

    public function messages()
    {
        return [
            'from_date.date' => 'Invalid Date Format.',
            'from_date.before' => 'Date must be before today.',
            'to_date.date' => 'Invalid date.',
            'to_date.before' => 'Date must be till today.',
            'currency.in' => 'Invalid currency.',
            'rating.in' => 'Invalid Rating',
            'hotel.exists' => 'Invalid hotel.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('from_date') !== null && $this->input('to_date') !== null) {
                if ($this->input('from_date') > $this->input('to_date')) {
                    $validator->errors()->add('from_date', 'Invalid date range');
                    $validator->errors()->add('to_date', 'Invalid date range');
                }
            }
        });
    }
}
