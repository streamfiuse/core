<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContentUsers extends Pivot
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo('User');
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo('Content');
    }
}
