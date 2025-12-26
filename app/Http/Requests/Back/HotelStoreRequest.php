<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HotelStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:191|unique:hotels,name',
            'location' => 'required|max:191',
            'code' => 'required|max:191',
            'description' => 'required',
            'star' => 'required|integer',
        ];
    }
}
