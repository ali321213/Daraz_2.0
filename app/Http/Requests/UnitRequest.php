<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true to allow all users to access this request
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'symbol' => 'required|string|min:1|max:5',
            'description' => 'required|string|min:5|max:1000',
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The unit name is required.',
            'name.min' => 'The unit name must be at least 3 characters.',
            'symbol.required' => 'The unit symbol is required.',
            'symbol.max' => 'The unit symbol must not exceed 5 characters.',
            'description.required' => 'The description is required.',
            'description.min' => 'The description must be at least 5 characters.',
        ];
    }
}