<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use libphonenumber\PhoneNumberFormat;

class UserCreationService
{
    public function create(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $phone = phone($validated['phone'], 'KE', PhoneNumberFormat::INTERNATIONAL);
        $validated['phone'] = $phone;
        return User::create($validated);
    }
}
