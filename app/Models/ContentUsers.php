<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContentUsers extends Pivot
{
    use HasFactory;

    protected $primaryKey = ['content_id', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo('Users');
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo('Contents');
    }
}
