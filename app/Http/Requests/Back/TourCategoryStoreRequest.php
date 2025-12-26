<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class TourCategoryStoreRequest extends FormRequest
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
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Category Name is required.',
            'status.required' => 'Select Category Status.'
        ];
    }
}
