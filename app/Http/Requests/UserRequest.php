<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'last_name_ru'  => 'required',
            'first_name_ru' => 'required',
            'user_login'    => 'unique:users',
            'email'         => 'unique:users',
            'country_id'    => 'gt:0',
            'img'           => 'image|mimes:jpg,jpeg,png,gif|max:2048'
        ];
    }
}
