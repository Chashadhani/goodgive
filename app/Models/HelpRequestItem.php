<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'help_request_id',
        'item_name',
        'quantity',
        'notes',
    ];

    public function helpRequest(): BelongsTo
    {
        return $this->belongsTo(HelpRequest::class);
    }
}
