<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fundraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FundraiserController extends Controller
{
    public static function makeRules()
    {
        return [
            "dob" => ["required", Rule::date()->format('Y-m-d')],
            "user_id" => ["required", "unique:fundraisers"],
            //validate image url once image has been uploaded
            "profile_picture" => ["required"],
            "id_number" => ["required"]
        ];
    }

    public static function makeMessages()
    {
        return [
            "dob.date_format" => "The dob field must match the format YYYY-MM-DD",
            "user_id.unique" => "A fundraiser profile already exists for this user.",
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Fundraiser::all()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), self::makeRules(), self::makeMessages());
        $validated = $validator->validated();
        return Fundraiser::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Fundraiser::findOrFail($id)->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fundraiser = Fundraiser::find($id);
        $rules = self::makeRules();
        array_pop($rules["user_id"]);
        if ($request->isMethod("patch")) {
            $rules = array_map(fn($value) => ['sometimes', ...$value], $rules);
        }
        $validator = Validator::make($request->all(), $rules, self::makeMessages());
        $validated = $validator->validated();
        foreach ($validated as $key => $value) {
            $fundraiser[$key] = $value;
        }
        $fundraiser->save();
        return Fundraiser::find($id)->toResource()->additional(["message" => "fundraiser has been successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Fundraiser::destroy($id);
        return Fundraiser::withTrashed()->find($id)->toResource()->additional(["message" => "Fundraiser has been successfully deleted"]);
    }
}
