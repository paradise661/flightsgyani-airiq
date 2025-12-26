<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class TourStoreRequest extends FormRequest
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
            'tour_code' => 'required|unique:tours,tour_code',
            'name' => 'required|unique:tours,name|max:191',
            'location' => 'required|max:191',
            'category' => 'required',
            'currency' => 'required|in:USD,NPR',
            'subcategory' => 'required',
            'duration' => 'required|max:191',
            'image' => 'required|file',

        ];
    }
}
