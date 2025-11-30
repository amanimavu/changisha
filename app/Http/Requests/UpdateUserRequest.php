<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'     => ['required'],
            'address'  => ['nullable', 'max:255'],
            'email'    => ['bail', 'required', 'unique:users', 'max:255', Rule::unique('users')->ignore($this->user)],
            'phone'    => ['bail', 'required', 'unique:users', 'phone:KE', Rule::unique('users')->ignore($this->user)],
            'username' => ['bail', 'required', 'unique:users', 'max:255', Rule::unique('users')->ignore($this->user)],
        ];

        // For PATCH requests, all fields are optional. They are only validated if present.
        if ($this->isMethod('patch')) {
            $rules = array_map(fn($value) => ['sometimes', ...$value], $rules);
        }

        return $rules;
    }
}
