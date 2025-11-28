<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a donation made by a user to a campaign.
 */
class Donation extends Model
{
    /** @use HasFactory<\Database\Factories\DonationFactory> */
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the user that made the donation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the campaign that the donation belongs to.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
