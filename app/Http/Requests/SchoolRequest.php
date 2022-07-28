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
        return [
            'name'       => 'required',
            'name_rus'   => 'required',
            'logo'       => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'country_id' => 'gt:0',
            //'email' => ['required', Rule::unique('schools')->ignore($this->get('school_id'))],
            //'phone' => 'required',
        ];
    }
}
