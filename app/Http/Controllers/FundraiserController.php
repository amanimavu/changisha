<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFundraiserRequest;
use App\Http\Requests\UpdateFundraiserRequest;
use App\Models\Fundraiser;

class FundraiserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Fundraiser::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraiserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fundraiser $fundraiser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fundraiser $fundraiser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundraiserRequest $request, Fundraiser $fundraiser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fundraiser $fundraiser)
    {
        //
    }
}
