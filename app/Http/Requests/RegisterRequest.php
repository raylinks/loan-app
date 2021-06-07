<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstname' => 'required|string|min:3|max:100',
            'lastname' => 'required|string|min:3|max:100',
            'email' => 'required|string|min:3|max:100',
            'callback_url' => 'required|string',
           // 'password' => ['required', 'string', 'confirmed', new ValidPassword()],
          //  'date_of_birth' => ['required', 'date', 'before_or_equal:18 years ago'],
            'phone_number' => 'required|string|unique:users',
           // 'password.regex' => 'It must contain at least one uppercase letter, one lowercase letter, one number and one special char',
        ];
    }
}
