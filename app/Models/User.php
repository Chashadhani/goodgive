<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * User type constants
     */
    const TYPE_ADMIN = 'admin';
    const TYPE_STAFF = 'staff';
    const TYPE_NGO = 'ngo';
    const TYPE_DONOR = 'donor';
    const TYPE_USER = 'user'; // Recipients/those who need help

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the donor profile associated with the user.
     */
    public function donorProfile(): HasOne
    {
        return $this->hasOne(DonorProfile::class);
    }

    /**
     * Get the NGO profile associated with the user.
     */
    public function ngoProfile(): HasOne
    {
        return $this->hasOne(NgoProfile::class);
    }

    /**
     * Get the recipient profile associated with the user.
     */
    public function recipientProfile(): HasOne
    {
        return $this->hasOne(RecipientProfile::class);
    }

    /**
     * Get help requests made by this user.
     */
    public function helpRequests(): HasMany
    {
        return $this->hasMany(HelpRequest::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->user_type === self::TYPE_ADMIN;
    }

    /**
     * Check if user is staff
     */
    public function isStaff(): bool
    {
        return $this->user_type === self::TYPE_STAFF;
    }

    /**
     * Check if user is NGO
     */
    public function isNgo(): bool
    {
        return $this->user_type === self::TYPE_NGO;
    }

    /**
     * Check if user is donor
     */
    public function isDonor(): bool
    {
        return $this->user_type === self::TYPE_DONOR;
    }

    /**
     * Check if user is a recipient (user who needs help)
     */
    public function isRecipient(): bool
    {
        return $this->user_type === self::TYPE_USER;
    }

    /**
     * Get the appropriate dashboard route for this user
     */
    public function getDashboardRoute(): string
    {
        return match($this->user_type) {
            self::TYPE_ADMIN => 'admin.dashboard',
            self::TYPE_STAFF => 'admin.dashboard', // Staff also goes to admin panel
            self::TYPE_NGO => 'ngo.dashboard',
            self::TYPE_DONOR => 'donor.dashboard',
            self::TYPE_USER => 'recipient.dashboard',
            default => 'home',
        };
    }

    /**
     * Get user type label
     */
    public function getUserTypeLabelAttribute(): string
    {
        return match($this->user_type) {
            self::TYPE_ADMIN => 'Administrator',
            self::TYPE_STAFF => 'Staff Member',
            self::TYPE_NGO => 'NGO',
            self::TYPE_DONOR => 'Donor',
            self::TYPE_USER => 'Recipient',
            default => 'User',
        };
    }
}
