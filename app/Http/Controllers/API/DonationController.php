<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donation;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Donation::all()->toResourceCollection();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Donation::find($id)->toResource();
    }
}
