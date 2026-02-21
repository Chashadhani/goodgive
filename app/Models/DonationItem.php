<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Allocations that draw from this specific item.
     */
    public function allocations(): HasMany
    {
        return $this->hasMany(Allocation::class);
    }

    /**
     * How many units remain after allocations.
     */
    public function getRemainingQuantityAttribute(): int
    {
        $allocated = $this->allocations()->sum('quantity');
        return max(0, $this->quantity - (int) $allocated);
    }

    /**
     * How many units have been allocated.
     */
    public function getAllocatedQuantityAttribute(): int
    {
        return (int) $this->allocations()->sum('quantity');
    }
}
