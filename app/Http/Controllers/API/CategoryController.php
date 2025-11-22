<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public static $rules = [
        'name' => ['required', 'unique:categories'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(self::$rules);

        return Category::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Category::find($id)->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        $validated = $request->validate(self::$rules);
        foreach ($validated as $key => $value) {
            $category[$key] = $value;
        }
        $category->save();

        return Category::find($id)->toResource()->additional(['message' => 'category has been successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Log::debug('category id: {id}', ['id' => $id]);
        Category::destroy($id);

        return Category::withTrashed()->find($id)->toResource()->additional(['message' => 'Category has been successfully deleted']);
    }
}
