<?php

namespace App\Http\Requests;

class SearchFlightRequest extends Request
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
//        dd($this->input());
        return [
            'type' => 'required',
            'departure' => 'required',
            'destination' => 'required',
            'flightdate' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'returndate' => 'required_if:type,R|date|date_format:Y-m-d|nullable|after_or_equal:flightdate',
            'nationality' => 'required',
            'flightadults' => 'integer|min:1',
            'flightchilds' => 'integer|min:0',
            'flightinfants' => 'lte:flightadults',
            'int_multi_from.*' => 'sometimes',
            'int_multi_to.*' => 'sometimes',
            'int_multi_departure.*' => 'sometimes|nullable|date_format:Y-m-d'
        ];
    }

    public function messages()
    {
        return [
            'departure.required' => 'Provide Departure/Location.',
            'destination.required' => 'Provide Arrival/Destination.',
            'flightdate.required' => 'Departure date is required.',
            'flightdate.date' => 'Invalid Date',
            'flightdate.after' => 'Provide valid Departure date.',
            'flight_date.date_format' => 'Invalid Format.',
            'returndate.required_if' => 'Return date is required.',
            'returndate.date_format' => 'Invalid Format.',
            'returndate.after_or_equal' => 'Return date must be after Departure Date.',
            'nationality' => 'Provide your nationality',
            'flightinfants.lte' => 'Infants can not be greater than adults.',
            'int_multi_from.*.sometimes' => 'Departure airport is required.',
            'int_multi_to.*.sometimes' => 'Arrival airport is required.',
            'int_multi_departure.*.sometimes' => 'Departure date is required.',
            'int_multi_departure.*.date_format' => 'Invalid Format.'
        ];
    }

    public function moreValidation($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('flightadults') + $this->input('flightchilds') + $this->input('flightinfants') > 9) {
                $validator->errors()->add('adults', 'Total Pax can not be greater than 9');
            }
        });
    }
}
