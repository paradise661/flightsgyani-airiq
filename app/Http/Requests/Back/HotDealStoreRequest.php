<?php

namespace App\Http\Requests\Back;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class HotDealStoreRequest extends FormRequest
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
            'airline' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'pax' => 'array',
            'amount' => 'required',
            'book_range' => 'required',
            'ticket_range' => 'required',
            'stops' => 'nullable|min:0'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $bookStart = explode('-', $this->input('book_range')[0]);
            $bookEnd = explode('-', $this->input('book_range')[1]);
//            if(Carbon::parse($bookStart)->diffInDays(Carbon::now()) < 0 || Carbon::parse($bookEnd)->diffInDays(Carbon::parse($bookStart)) > 0){
//                $validator->errors()->add('book_range','Invalid Date Range');
//            }
        });
    }
}
