<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:100',
            'marital_status' => 'required|string|min:3|max:100',
            'address' => 'required|string|max:255',
            'cuurent_employment' => 'required|string',
            'occupation' =>  'required|string',
            'years_of_employment' =>  'required|string',
            'monthly income' => 'required|numeric|digits:11',
            'profile_picture' => 'required|string|min:3|max:100',
        ];
    }
}
