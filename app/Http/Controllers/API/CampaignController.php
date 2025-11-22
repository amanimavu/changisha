<?php

namespace App\Http\Controllers\API;

use App\Enum\Privacy;
use App\Enum\Status;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CampaignController extends Controller
{
    public static function makeRules()
    {
        return [
            'title'          => ['required', 'string'],
            'description'    => ['required', 'string'],
            'start_date'     => ['required', Rule::date()->format('Y-m-d')],
            'end_date'       => ['required', Rule::date()->format('Y-m-d'), 'after:start_date'],
            'goal'           => ['required', 'decimal:0,2'],
            'status'         => [Rule::enum(Status::class)->only([Status::cancelled, Status::active])],
            'campaign_image' => ['required', 'string', 'url:https'],
            'paybill_number' => ['required', 'integer'],
            'privacy'        => [Rule::enum(Privacy::class)],
            'category_id'    => ['required', 'integer', 'gt:0'],
            'fundraiser_id'  => ['required', 'integer', 'gt:0'],
        ];
    }

    public static function makeMessages()
    {
        return [
            'start_date.date_format' => 'The start_date field must match the format YYYY-MM-DD',
            'end_date.date_format'   => 'The end_date field must match the format YYYY-MM-DD',
            'status'                 => "You may only set the status to 'active' or 'cancelled'",
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Campaign::all()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), self::makeRules(), self::makeMessages());
        $validated = $validator->validated();

        return Campaign::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Campaign::find($id)->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $campaign = Campaign::find($id);
        $rules = self::makeRules();
        if ($request->isMethod('patch')) {
            $rules = array_map(fn ($value) => ['sometimes', ...$value], $rules);
        }
        $validator = Validator::make($request->all(), $rules, self::makeMessages());
        $validated = $validator->validated();
        foreach ($validated as $key => $value) {
            $campaign[$key] = $value;
        }
        $campaign->save();

        return Campaign::find($id)->toResource()->additional(['message' => 'campaign has been successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Campaign::destroy($id);

        return Campaign::withTrashed()->find($id)->toResource()->additional(['message' => 'Campaign has been successfully deleted']);
    }
}
