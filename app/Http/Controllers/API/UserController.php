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

    public static $rules = [
        'name' => ['required'],
        'address' => ['nullable', 'max:255'],
        'email' => ['bail', 'required', "unique:users,email", 'max:255'],
        'phone' => ['bail', 'required', 'unique:users,phone', 'max:255'],
        'username' => ['bail', 'required', 'unique:users,username', 'max:255'],
        'password' => ['bail', 'required', 'unique:users',]
    ];

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $validated = $request->validate(self::$rules);
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
        $user = User::find($id);
        $rules = self::$rules;
        array_pop($rules);
        if ($request->isMethod("patch")) {
            $rules = array_map(fn($value) => ['sometimes', ...$value], $rules);
        }
        $validated = $request->validate($rules);
        foreach ($validated as $key => $value) {
            $user[$key] = $value;
        }
        $user->save();
        return User::find($id)->toResource()->additional(["message" => "user has been successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return User::withTrashed()->find($id)->toResource()->additional(["message" => "user has been successfully deleted"]);
    }
}
