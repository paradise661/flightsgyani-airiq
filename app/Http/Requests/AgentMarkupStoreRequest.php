<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgentMarkupStoreRequest extends FormRequest
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
        $id = $this->input('markup');
        return [
            'adtnprmargin' => 'required',
            'adtusdmargin' => 'required',
            'chdnprmargin' => 'required',
            'chdusdmargin' => 'required',
            'infnprmargin' => 'required',
            'infusdmargin' => 'required',
            'triptype' => 'required|in:O,R,A',
            'status' => 'required|in:0,1',
            'stdusdmargin' => 'required',
            'stdnprmargin' => 'required',
            'lbrusdmargin' => 'required',
            'lbrnprmargin' => 'required',
            'priority' => ['integer', 'min:0', 'required', Rule::unique('agent_markups', 'priority')->ignore($id)]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (is_array($this->input('type')) && count($this->input('type')) > 0) {
                $values = array_values($this->input('type'));
                if (in_array('sector', $values, true) && $this->input('origin') == null) {
                    $validator->errors()->add('origin', 'Sector Origin is required.');
                }
                if (in_array('sector', $values, true) && $this->input('destination') == null) {
                    $validator->errors()->add('destination', 'Sector destination is required.');
                }
                if (in_array('airline', $values, true) && $this->input('airline') == null) {
                    $validator->errors()->add('airline', 'Airline is required.');
                }

            }

        });
    }

    public function messages()
    {
        return [
            'adtnprmargin.required' => 'Adult Margin in NPR is required. If not put 0.',
            'adtusdmargin.required' => 'Adult Margin in USD is required. If not put 0.',
            'chdnprmargin.required' => 'Child Margin in NPR is required. If not put 0.',
            'chdusdmargin.required' => 'Child Margin in USD is required. If not put 0.',
            'infnprmargin.required' => 'Infant Margin in NPR is required. If not put 0.',
            'infusdmargin.required' => 'Infant Margin in USD is required. If not put 0.',
            'triptype.required' => 'Select Trip Type.',
            'triptype.in' => 'Trip Type is Invalid.',
            'status.required' => 'Status is required.',
            'status.in' => 'Invalid Value.',
            'priority.required' => 'Rule priority is required.',
            'priority.integer' => 'Priority must be number.',
            'priority.unique' => 'This priority is already taken by another rule.'
        ];
    }
}
