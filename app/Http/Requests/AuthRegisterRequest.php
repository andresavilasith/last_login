<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:4',
            'phone' => 'required',
            'image' => 'mimes:jpg,jpeg,png|nullable',
            'last_login_date' => 'date|nullable'
        ];
    }
}
