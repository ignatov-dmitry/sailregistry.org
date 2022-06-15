<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        //dd($this->all());
        return [
            'name'  => 'required',
            'email' => ['required', Rule::unique('schools')->ignore($this->get('school_id'))],
            'phone' => 'required',
            'logo'  => 'image|mimes:jpg,jpeg,png,gif|max:2048'
        ];
    }
}
