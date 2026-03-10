<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required', 'max:255'],
            'image' => ['required', 'file', 'mimes:jpeg,png'],
            'category_id' => ['required'],
            'condition' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
}