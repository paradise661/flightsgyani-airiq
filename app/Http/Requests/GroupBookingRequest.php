<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupBookingRequest extends FormRequest
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
            'contact_number' => 'required',
            'departure' => 'required|max:191|string',
            'arrival' => 'required|max:191|string',
            'adults' => 'required|min:1|integer',
            'childs' => 'sometimes|nullable|integer|min:1',
            'infants' => 'sometimes|nullable|integer|min:1|lte:adults',
            'depart_date' => 'required|date|after:today',
            'return_date' => 'sometimes|nullable|date|after_or_equal:depart_date',
            'airline' => 'sometimes|nullable|string|max:191'
        ];
    }

    public function messages()
    {
        return [
            'contact_number.required' => 'Provide contact number.',
            'departure.required' => 'Departure location is required.',
            'departure.max' => 'Invalid value',
            'departure.string' => 'Invalid value',
            'arrival.required' => 'Destination is required.',
            'arrival.max' => 'Invalid value',
            'arrival.string' => 'Invalid value',
            'adults.required' => 'Provide number of adults.',
            'adults.min' => 'Adult must be present.',
            'adults.integer' => 'Invalid value.',
            'childs.integer' => 'Invalid value.',
            'childs.min' => 'Invalid value.',
            'infants.integer' => 'Invalid value.',
            'infants.min' => 'Invalid value.',
            'infants.lte' => 'Infants can not be more than adults.',
            'depart_date.required' => 'Departure date is required.',
            'depart_date.date' => 'Invalid date',
            'depart_date.after' => 'Invalid date',
            'return_date.date' => 'Invalid date.',
            'return_date.after' => 'Return date must be after departure date.',
            'airline.string' => 'Invalid value.',
            'airline.max' => 'Invalid value.'
        ];
    }
}
