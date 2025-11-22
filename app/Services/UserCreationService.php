<?php

namespace App\Services;

use App\Http\Requests\SaveUserRequest;
use App\Models\User;

class UserCreationService
{
    public function create(SaveUserRequest $request)
    {
        $validated = $request->validated();
        return User::create($validated);
    }
}
