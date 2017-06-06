<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|unique:users,name'. (FormRequest::get('id') !== null ? ',' . FormRequest::get('id') : '') ,
            'email' => 'required|unique:users,email'. (FormRequest::get('id') !== null ? ',' . FormRequest::get('id') : ''),
            'avatar' => 'image|max:1000',
        ];
    }
}
