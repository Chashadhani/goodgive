<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Donation extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REJECTED = 'rejected';

    const TYPE_MONEY = 'money';
    const TYPE_GOODS = 'goods';

    protected $fillable = [
        'user_id',
        'ngo_post_id',
        'donation_type',
        'amount',
        'status',
        'donor_notes',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the donor (user) who made this donation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias for user relationship.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the NGO post this donation is linked to (optional).
     */
    public function ngoPost(): BelongsTo
    {
        return $this->belongsTo(NgoPost::class);
    }

    /**
     * Get the admin who reviewed this donation.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the items for this goods donation.
     */
    public function items(): HasMany
    {
        return $this->hasMany(DonationItem::class);
    }

    /**
     * Allocations that draw from this donation.
     */
    public function allocations(): HasMany
    {
        return $this->hasMany(Allocation::class);
    }

    /**
     * Get a summary string of goods items.
     */
    public function getGoodsSummaryAttribute(): string
    {
        return $this->items->map(fn($item) => $item->quantity . 'x ' . $item->item_name)->implode(', ');
    }

    /**
     * Remaining money after allocations.
     */
    public function getRemainingAmountAttribute(): float
    {
        if (!$this->isMoney()) return 0;
        $allocated = $this->allocations()->where('type', 'money')->sum('amount');
        return max(0, (float) $this->amount - (float) $allocated);
    }

    /**
     * Check if this donation has available stock.
     */
    public function getHasAvailableStockAttribute(): bool
    {
        if (!$this->isConfirmed()) return false;

        if ($this->isMoney()) {
            return $this->remaining_amount > 0;
        }

        // For goods: check if any item has remaining quantity
        return $this->items->contains(fn($item) => $item->remaining_quantity > 0);
    }

    /**
     * Get total items count.
     */
    public function getTotalItemsCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Scope: pending donations.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope: confirmed donations.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * Scope: money donations.
     */
    public function scopeMoney($query)
    {
        return $query->where('donation_type', self::TYPE_MONEY);
    }

    /**
     * Scope: goods donations.
     */
    public function scopeGoods($query)
    {
        return $query->where('donation_type', self::TYPE_GOODS);
    }

    /**
     * Check if donation is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if donation is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * Check if donation is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Check if this is a money donation.
     */
    public function isMoney(): bool
    {
        return $this->donation_type === self::TYPE_MONEY;
    }

    /**
     * Check if this is a goods donation.
     */
    public function isGoods(): bool
    {
        return $this->donation_type === self::TYPE_GOODS;
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'orange',
            self::STATUS_CONFIRMED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray',
        };
    }

    /**
     * Get formatted donation type label.
     */
    public function getDonationTypeLabelAttribute(): string
    {
        return match($this->donation_type) {
            self::TYPE_MONEY => 'Money',
            self::TYPE_GOODS => 'Goods',
            default => 'Unknown',
        };
    }
}
