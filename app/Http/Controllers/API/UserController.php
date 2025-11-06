<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        // validate request
        $validated = $request->validate([
            'name' => ['required'],
            'address' => ['nullable', 'max:255'],
            'email' => ['bail', 'required', "unique:users,email", 'max:255'],
            'phone' => ['bail', 'required', 'unique:users,phone', 'max:255'],
            'username' => ['bail', 'required', 'unique:users,username', 'max:255'],
            'password' => ['bail', 'required', 'unique:users',]
        ]);
        return User::create($validated);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return User::destroy($id);
    }
}
