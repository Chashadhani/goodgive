<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'location',
        'amount_needed',
        'urgency',
        'documents',
        'status',
        'rejection_reason',
        'admin_notes',
        'approved_at',
        'fulfilled_at',
    ];

    protected $casts = [
        'amount_needed' => 'decimal:2',
        'approved_at' => 'datetime',
        'fulfilled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
            'other' => 'Other',
            default => $this->category,
        };
    }

    public function getUrgencyLabelAttribute(): string
    {
        return match($this->urgency) {
            'low' => 'Low',
            'normal' => 'Normal',
            'high' => 'High',
            'critical' => 'Critical',
            default => $this->urgency,
        };
    }

    public function getUrgencyColorAttribute(): string
    {
        return match($this->urgency) {
            'low' => 'gray',
            'normal' => 'blue',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'orange',
            'approved' => 'green',
            'in_progress' => 'blue',
            'fulfilled' => 'indigo',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}
