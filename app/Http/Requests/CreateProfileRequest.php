<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfileRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:10',
            'marital_status' => 'required|string',
            'date_of_birth' => [ 'date', 'before_or_equal:18 years ago'],
            'address' => 'required|string|max:255',
            'current_employment' => 'required|string',
            'occupation' =>  'required|string',
            'years_of_employment' =>  'required|numeric|min:1|max:2',
            'monthly_income' => 'required|string',
            //'profile_picture' => 'required|string|min:3|max:100',
        ];
    }
}
