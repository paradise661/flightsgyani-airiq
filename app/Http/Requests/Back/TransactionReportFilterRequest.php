<?php

namespace App\Http\Requests\Back;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TransactionReportFilterRequest extends FormRequest
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

        ];

    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('from_date') !== null && $this->input('to_date') !== null) {
                if (Carbon::parse($this->input('from_date'))->diffInDays(Carbon::parse($this->input('to_date'))) < 0) {
                    $validator->errors()->add('from_date', 'Must be before ending date');
                }
            }
        });
    }
}
