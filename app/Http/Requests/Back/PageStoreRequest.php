<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
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
            'name' => 'required',
            'pagecontent' => 'required',
            'title' => 'required',
            'status' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Menu Name is required.',
            'pagecontent.required' => 'Page content is required.',
            'title.required' => 'Page title is required.',
            'status.required' => 'Status is required.',
            'status.boolean' => 'Invalid Data.'
        ];
    }
}
