<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserCreationService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserCreationService $userCreationService)
    {
        return $userCreationService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::findOrFail($id)->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        $validated = $request->validated();
        foreach ($validated as $key => $value) {
            $user[$key] = $value;
        }
        $user->save();

        return User::find($id)->toResource()->additional(['message' => 'user has been successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);

        return User::withTrashed()->find($id)->toResource()->additional(['message' => 'user has been successfully deleted']);
    }
}
