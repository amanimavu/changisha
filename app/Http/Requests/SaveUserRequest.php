<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveUserRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
            'email'    => ['bail', 'required', 'unique:users', 'max:255'],
            'phone'    => ['bail', 'required', 'unique:users', 'max:255'],
            'username' => ['bail', 'required', 'unique:users', 'max:255'],
            'password' => ['bail', 'required', 'unique:users'],
        ];
        $method = strtolower($this->method());
        if ($method !== 'post') {
            $rules['email'][2] = Rule::unique('users')->ignore($this->user);
            $rules['phone'][2] = Rule::unique('users')->ignore($this->user);
            $rules['username'][2] = Rule::unique('users')->ignore($this->user);

            if ($this->isMethod('patch')) {
                $rules = array_map(fn ($value) => ['sometimes', ...$value], $rules);
            }
        }

        return $rules;
    }
}
