<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            $rules = [
                'title' => 'required|min:3|unique:blogs,title',
                'description' => 'required',
                'image' => 'required',
            ];
            return $rules;
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $blog = $this->route('blog');
            $rules = [
                'title' => 'required|min:3|unique:blogs,title,' . $blog->id,
                'description' => 'required',
            ];
            return $rules;
        }
    }
}
