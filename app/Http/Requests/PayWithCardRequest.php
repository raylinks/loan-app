<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayWithCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'amount' => 'required|numeric|min:1000|max:20000',
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'amount.required' => 'amount  cannot be empty',
        ];
    }
}