<?php

declare(strict_types=1);

namespace App\BusinessDomain\Fiuselist\Rule;

use App\Models\User;

class DoesUserAlreadyDislikeOrNotInteractWithContentRule
{
    public function appliesTo(User $user, string $contentId): bool
    {
        return (bool) $user->contents()->where('content_id', '=', $contentId)
            ->where('like_status', '=', 'disliked', 'or')
            ->where('like_status', '=', 'no_interaction')
            ->count();
    }
}
