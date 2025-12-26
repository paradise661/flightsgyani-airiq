<?php

namespace App\Http\Requests\Back;

use App\Model\TourCategory;
use App\Model\TourSubCategory;
use Illuminate\Foundation\Http\FormRequest;

class TourReportFilterRequest extends FormRequest
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
            'from_date' => 'nullable|date|date_format:d-m-Y',
            'to_date' => 'nullable|date|date_format:d-m-Y',
            'currency' => 'in:All,NPR,USD',
            'category' => 'nullable|exists:tour_categories,slug',
            'subcat' => 'nullable|exists:tour_sub_categories,slug',
            'tours' => 'nullable|exists:tours,slug'
        ];

    }


    public function messages()
    {
        return [
            'from_date.date' => 'Invalid Date Format.',
            'from_date.before' => 'Date must be before today.',
            'to_date.date' => 'Invalid date.',
            'to_date.before' => 'Date must be till today.',
            'currency.in' => 'Invalid currency.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('category') != null && $this->input('subcat')) {
                $cat = TourCategory::where('slug', $this->input('category'))->first();
                $sub = TourSubCategory::where('slug', $this->input('subcat'))->first();
                if (!$sub->tour_category_id == $cat->id) {
                    $validator->errors()->add('subcat', 'Invalid subcategory of selected category.');
                }
            }
            if ($this->input('from_date') !== null && $this->input('to_date') !== null) {
                if ($this->input('from_date') > $this->input('to_date')) {
                    $validator->errors()->add('to_date', 'Invalid date range.');
                    $validator->errors()->add('from_date', 'Invalid date range.');
                }
            }
        });
    }
}
