<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class NgoPost extends Model
{
    use HasFactory;

    const TYPE_MONEY = 'money';
    const TYPE_GOODS = 'goods';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'image',
        'urgency',
        'request_type',
        'goal_amount',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'goal_amount' => 'decimal:2',
    ];

    /**
     * The NGO user who created this post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The admin/staff who reviewed this post.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Items requested (for goods type posts).
     */
    public function items(): HasMany
    {
        return $this->hasMany(NgoPostItem::class);
    }

    /**
     * Donations made to this NGO post by donors.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Allocations made to this post from stock.
     */
    public function allocations(): MorphMany
    {
        return $this->morphMany(Allocation::class, 'allocatable');
    }

    public function isMoney(): bool
    {
        return $this->request_type === self::TYPE_MONEY;
    }

    public function isGoods(): bool
    {
        return $this->request_type === self::TYPE_GOODS;
    }

    public function getGoodsSummaryAttribute(): string
    {
        return $this->items->map(function ($item) {
            return $item->quantity . 'x ' . $item->item_name;
        })->implode(', ');
    }

    public function getTotalItemsCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Scope: only approved posts.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: only pending posts.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isFulfilled(): bool
    {
        return $this->status === 'fulfilled';
    }

    /**
     * Total confirmed money donated to this post.
     */
    public function getConfirmedMoneyAttribute(): float
    {
        return (float) $this->donations()
            ->where('status', 'confirmed')
            ->where('donation_type', 'money')
            ->sum('amount');
    }

    /**
     * Money progress percentage (capped at 100).
     */
    public function getMoneyProgressPercentAttribute(): float
    {
        if (!$this->goal_amount || $this->goal_amount <= 0) {
            return 0;
        }
        return min(100, round(($this->confirmed_money / $this->goal_amount) * 100, 1));
    }

    /**
     * Check if the money goal has been met or exceeded.
     */
    public function isMoneyGoalMet(): bool
    {
        return $this->isMoney() && $this->goal_amount && $this->confirmed_money >= $this->goal_amount;
    }

    /**
     * Get confirmed donated quantities per item name for goods posts.
     * Returns array like ['Rice bags' => 5, 'Shirts' => 10]
     */
    public function getConfirmedGoodsDonatedAttribute(): array
    {
        $donated = [];
        $donations = $this->donations()
            ->where('status', 'confirmed')
            ->where('donation_type', 'goods')
            ->with('items')
            ->get();

        foreach ($donations as $donation) {
            foreach ($donation->items as $item) {
                $key = $item->item_name;
                $donated[$key] = ($donated[$key] ?? 0) + $item->quantity;
            }
        }

        return $donated;
    }

    /**
     * Overall goods progress percentage (average across all items, capped at 100).
     */
    public function getGoodsProgressPercentAttribute(): float
    {
        if (!$this->isGoods() || $this->items->isEmpty()) {
            return 0;
        }

        $donated = $this->confirmed_goods_donated;
        $totalPercent = 0;

        foreach ($this->items as $item) {
            $itemDonated = $donated[$item->item_name] ?? 0;
            $totalPercent += min(100, ($item->quantity > 0 ? ($itemDonated / $item->quantity) * 100 : 0));
        }

        return min(100, round($totalPercent / $this->items->count(), 1));
    }

    /**
     * Check if all goods items have been fully donated.
     */
    public function isGoodsGoalMet(): bool
    {
        if (!$this->isGoods() || $this->items->isEmpty()) {
            return false;
        }

        $donated = $this->confirmed_goods_donated;

        foreach ($this->items as $item) {
            if (($donated[$item->item_name] ?? 0) < $item->quantity) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the overall goal (money or goods) has been met.
     */
    public function isGoalMet(): bool
    {
        if ($this->isMoney()) {
            return $this->isMoneyGoalMet();
        }
        return $this->isGoodsGoalMet();
    }
}
