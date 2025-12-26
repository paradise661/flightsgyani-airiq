<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyTicketUpdateRequest extends FormRequest
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
            'user_id' => [
                'required',
                Rule::unique('company_ticket_details', 'user_id')->ignore($this->route('ticket')->id ?? null),
            ],
            'company_name' => 'required',
            'company_email' => 'required',
            'company_contact' => 'required',
            'emergency_contact' => 'required',
            'company_address' => 'required',
            'contact_details' => 'required',
            'domestic_flight_rules' => 'required',
            'international_flight_rules' => 'required'
        ];
    }
}
