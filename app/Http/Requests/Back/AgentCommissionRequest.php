<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class AgentCommissionRequest extends FormRequest
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
        $rules = [];
        foreach (\App\Model\Team::all() as $team) {
            $rules[$team->name . 'adtusdmargin'] = 'required';
            $rules[$team->name . 'adtnprmargin'] = 'required';
            $rules[$team->name . 'chdnprmargin'] = 'required';
            $rules[$team->name . 'chdusdmargin'] = 'required';
            $rules[$team->name . 'infusdmargin'] = 'required';
            $rules[$team->name . 'infnprmargin'] = 'required';
            $rules[$team->name . 'stdnprmargin'] = 'required';
            $rules[$team->name . 'stdusdmargin'] = 'required';
            $rules[$team->name . 'lbrusdmargin'] = 'required';
            $rules[$team->name . 'lbrnprmargin'] = 'required';


        }
        $rules['priority'] = 'required';

        return $rules;
    }

    public function messages()
    {
        $messages = [];
        foreach (\App\Model\Team::all() as $team) {
            $messages[$team->name . 'adtusdmargin.required'] = 'USD margin of adult for ' . $team->name . ' group is required';
            $messages[$team->name . 'adtnprmargin.required'] = 'NPR margin of adult for ' . $team->name . ' group is required';
            $messages[$team->name . 'chdusdmargin.required'] = 'USD margin of child for ' . $team->name . ' group is required';
            $messages[$team->name . 'chdnprmargin.required'] = 'NPR margin of child for ' . $team->name . ' group is required';
            $messages[$team->name . 'infnprmargin.required'] = 'NPR margin of infant for ' . $team->name . ' group is required';
            $messages[$team->name . 'infusdmargin.required'] = 'USD margin of infant for ' . $team->name . ' group is required';
            $messages[$team->name . 'stdnprmargin.required'] = 'NPR margin of student for ' . $team->name . ' group is required';
            $messages[$team->name . 'stdusdmargin.required'] = 'USD margin of student for ' . $team->name . ' group is required';
            $messages[$team->name . 'lbrusdmargin.required'] = 'USD margin of labour for ' . $team->name . ' group is required';
            $messages[$team->name . 'lbrnprmargin.required'] = 'NPR margin of labour for ' . $team->name . ' group is required';
        }
        $messages['priority.required'] = 'Priority for rule application is required.';
        return $messages;
    }
}
