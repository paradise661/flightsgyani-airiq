<?php

namespace App\Http\Requests\B2B;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'company_name' => 'required',
            'company_email' => 'required',
            'company_contact' => 'required',
            'emergency_contact' => 'required',
            'company_address' => 'required',
            // 'contact_details' => 'required',
        ];
    }
}
