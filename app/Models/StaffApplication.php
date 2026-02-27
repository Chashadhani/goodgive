<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'nic',
        'address',
        'position',
        'experience',
        'motivation',
        'resume',
        'status',
        'reviewed_by',
        'reviewed_at',
        'admin_notes',
        'generated_username',
        'generated_password_plain',
        'user_id',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // ─── Relationships ─────────────────────────────────────

    /**
     * The admin who reviewed this application.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * The user account created upon approval.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ─── Status helpers ────────────────────────────────────

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

    // ─── Accessors ─────────────────────────────────────────

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPositionLabelAttribute(): string
    {
        return match ($this->position) {
            'field_officer' => 'Field Officer',
            'coordinator' => 'Coordinator',
            'volunteer_manager' => 'Volunteer Manager',
            'logistics' => 'Logistics & Distribution',
            'data_entry' => 'Data Entry Operator',
            'community_outreach' => 'Community Outreach',
            'other' => 'Other',
            default => $this->position ?? 'Not specified',
        };
    }
}
