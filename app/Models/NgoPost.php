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
}
