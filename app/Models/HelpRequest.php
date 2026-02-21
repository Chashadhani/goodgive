<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HelpRequest extends Model
{
    use HasFactory;

    const TYPE_MONEY = 'money';
    const TYPE_GOODS = 'goods';

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'location',
        'amount_needed',
        'urgency',
        'request_type',
        'documents',
        'status',
        'rejection_reason',
        'admin_notes',
        'approved_at',
        'fulfilled_at',
        'reviewed_by',
        'reviewed_at',
        'completed_at',
    ];

    protected $casts = [
        'amount_needed' => 'decimal:2',
        'approved_at' => 'datetime',
        'fulfilled_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(HelpCategory::class, 'category', 'slug');
    }

    /**
     * Items needed (for goods type requests).
     */
    public function items(): HasMany
    {
        return $this->hasMany(HelpRequestItem::class);
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

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isFulfilled(): bool
    {
        return $this->status === 'fulfilled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'education' => 'Education',
            'healthcare' => 'Healthcare',
            'shelter' => 'Shelter',
            'food' => 'Food Security',
            'clothing' => 'Clothing',
            'emergency' => 'Emergency Relief',
            'livelihood' => 'Livelihood',
            'other' => 'Other',
            default => $this->category,
        };
    }

    public function getUrgencyLabelAttribute(): string
    {
        return match($this->urgency) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'critical' => 'Critical',
            default => $this->urgency,
        };
    }

    public function getUrgencyColorAttribute(): string
    {
        return match($this->urgency) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-indigo-100 text-indigo-800',
            'fulfilled' => 'bg-indigo-100 text-indigo-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
