<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'location',
        'need_category', // Keep for general categorization
        'description', // Brief about the user's situation
        'documents', // ID verification documents
        'status', // pending, approved, rejected (account status)
        'rejection_reason',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if user account is approved to make help requests
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->need_category) {
            'education' => 'Education',
            'healthcare' => 'Healthcare',
            'shelter' => 'Shelter',
            'food' => 'Food Security',
            'clothing' => 'Clothing',
            'emergency' => 'Emergency Relief',
            'other' => 'Other',
            default => $this->need_category ?? 'Not specified',
        };
    }
}
