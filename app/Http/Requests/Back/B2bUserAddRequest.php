<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class B2bUserAddRequest extends FormRequest
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

        if ($this->input('user')) {
            $id = decrypt($this->input('user'));
        }

        if (isset($id)) {
            return [
                'agencytype' => 'exists:teams,name',
                'agencyname' => 'required|max:191',
                'email' => ['required', Rule::unique('users', 'email')->ignore($id)],
                'password' => 'nullable|min:6|max:12',
                'name' => 'required|max:191',
                'address' => 'required|max:191',
                'contact' => 'required|max:191',
            ];
        } else {
            return [
                'agencytype' => 'exists:teams,name',
                'agencyname' => 'required|max:191',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:6|max:12',
                'name' => 'required|max:191',
                'address' => 'required|max:191',
                'contact' => 'required|max:191',
            ];
        }

    }

    public function messages()
    {
        return [
            'agencytype.exists' => 'Agency type not found.',
            'agencyname.required' => 'Agency name is required.',
            'agencyname.max' => 'Agency name can not be longer than 191.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Provide a valid email.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password is too weak.',
            'password.min' => 'Password must be longer than 6 characters.',
            'name.required' => 'Contact name is required.',
            'name.max' => 'Contact name can not be longer than 191 characters.',
            'address.required' => 'Agency address is required.',
            'address.max' => 'Address can not be longer than 191 characters.',
            'contact.required' => 'Agency contact number is required.',
            'contact.max' => 'Agency contact number is not valid.'
        ];
    }
}
