<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "title",
        "description",
        "fundraiser_id",
        "start_date",
        "end_date",
        "goal",
        "funds_raised",
        "status",
        "campaign_image",
        "paybill_number",
        "privacy",
        "category_id"
    ];

    public function fundraiser(): BelongsTo
    {
        return $this->belongsTo(Fundraiser::class);
    }

    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
