<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NgoPostItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ngo_post_id',
        'item_name',
        'quantity',
        'notes',
    ];

    public function ngoPost(): BelongsTo
    {
        return $this->belongsTo(NgoPost::class);
    }
}
