<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => ['required', 'min:4' , 'max:50', 'regex:/^(?=.{4,25}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/', 'unique:users,username'],
            'password' => ['required', 'min:4', 'max:25', 'confirmed'],
            'role' => ['required', 'exists:roles,id'],
            'password_confirmation' => ['required']
        ];
    }
}
