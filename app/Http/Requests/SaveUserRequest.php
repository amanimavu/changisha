<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class SaveUserRequest
 *
 * Handles the validation for creating and updating a user.
 */
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
     *
     * @return bool Always returns true, allowing any authenticated user to attempt the request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation logic for user data. The rules are dynamic
     * and change based on whether the request is for creating (POST) or
     * updating (PUT/PATCH) a user.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Base rules for creating a new user (POST request).
        $rules = [
            'name'     => ['required'],
            'address'  => ['nullable', 'max:255'],
            'email'    => ['bail', 'required', 'unique:users', 'max:255'],
            'phone'    => ['bail', 'required', 'unique:users', 'phone:KE'],
            'username' => ['bail', 'required', 'unique:users', 'max:255'],
            'password' => ['bail', 'required'],
        ];

        $method = strtolower($this->method());
        // Modify rules for update requests (PUT/PATCH).
        if ($method !== 'post') {
            // When updating, the unique rule should ignore the current user's record.
            $rules['email'][2] = Rule::unique('users')->ignore($this->user);
            $rules['phone'][2] = Rule::unique('users')->ignore($this->user);
            $rules['username'][2] = Rule::unique('users')->ignore($this->user);
            unset($rules['password']);

            // For PATCH requests, all fields are optional. They are only validated if present.
            if ($this->isMethod('patch')) {
                $rules = array_map(fn ($value) => ['sometimes', ...$value], $rules);
            }
        }

        return $rules;
    }
}
