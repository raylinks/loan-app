<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
            'accountName' => 'required|string',
            'accountType' => 'required|string',
            'email' => 'required|email',
            'customerName' => 'required|string',
            'bvn' => ['required', 'numeric', 'digits:11'],
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
            'accountName.required' => 'Account name cannot be empty',
            'accountType.required' => 'Account type cannot be empty',
            'bvn.required' => 'BVN cannot be empty',
        ];
    }
}