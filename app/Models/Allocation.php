<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Allocation extends Model
{
    use HasFactory;

    const STATUS_PROCESSING = 'processing';
    const STATUS_DELIVERY = 'delivery';
    const STATUS_DISTRIBUTED = 'distributed';

    const TYPE_MONEY = 'money';
    const TYPE_GOODS = 'goods';

    protected $fillable = [
        'donation_id',
        'donation_item_id',
        'allocatable_type',
        'allocatable_id',
        'allocated_by',
        'type',
        'amount',
        'quantity',
        'item_name',
        'status',
        'proof_photo',
        'proof_notes',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────

    /**
     * The source donation this allocation comes from.
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    /**
     * The specific donation item (for goods).
     */
    public function donationItem(): BelongsTo
    {
        return $this->belongsTo(DonationItem::class);
    }

    /**
     * The target (NgoPost or HelpRequest).
     */
    public function allocatable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * The admin who created this allocation.
     */
    public function allocatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }

    // ─── Status helpers ────────────────────────────────────

    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isDelivery(): bool
    {
        return $this->status === self::STATUS_DELIVERY;
    }

    public function isDistributed(): bool
    {
        return $this->status === self::STATUS_DISTRIBUTED;
    }

    public function isMoney(): bool
    {
        return $this->type === self::TYPE_MONEY;
    }

    public function isGoods(): bool
    {
        return $this->type === self::TYPE_GOODS;
    }

    // ─── Accessors ─────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PROCESSING => '⏳ Processing',
            self::STATUS_DELIVERY => '🚚 In Delivery',
            self::STATUS_DISTRIBUTED => '✅ Distributed',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PROCESSING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_DELIVERY => 'bg-blue-100 text-blue-800',
            self::STATUS_DISTRIBUTED => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Human-readable target label.
     */
    public function getTargetLabelAttribute(): string
    {
        if ($this->allocatable_type === NgoPost::class) {
            return 'NGO Post: ' . ($this->allocatable?->title ?? '#' . $this->allocatable_id);
        }
        if ($this->allocatable_type === HelpRequest::class) {
            return 'Help Request: ' . ($this->allocatable?->title ?? '#' . $this->allocatable_id);
        }
        return 'Unknown';
    }

    /**
     * Get the next allowed status.
     */
    public function getNextStatusAttribute(): ?string
    {
        return match ($this->status) {
            self::STATUS_PROCESSING => self::STATUS_DELIVERY,
            self::STATUS_DELIVERY => self::STATUS_DISTRIBUTED,
            default => null,
        };
    }

    public function getNextStatusLabelAttribute(): ?string
    {
        return match ($this->next_status) {
            self::STATUS_DELIVERY => '🚚 Move to Delivery',
            self::STATUS_DISTRIBUTED => '✅ Mark as Distributed',
            default => null,
        };
    }
}
