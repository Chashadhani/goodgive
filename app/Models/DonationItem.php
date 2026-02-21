<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'item_name',
        'quantity',
        'notes',
    ];

    /**
     * Get the donation this item belongs to.
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }
}
