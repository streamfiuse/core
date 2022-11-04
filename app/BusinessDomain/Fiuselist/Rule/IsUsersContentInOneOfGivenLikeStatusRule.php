<?php

declare(strict_types=1);

namespace App\BusinessDomain\Fiuselist\Rule;

use App\Models\User;

class IsUsersContentInOneOfGivenLikeStatusRule
{
    public function appliesTo(User $user, string $contentId, array $like_status): bool
    {
        $contents = $user->contents()->where('content_id', '=', $contentId);
        if (\count($like_status) > 1) {
            foreach ($like_status as $status) {
                $contents->where('like_status', '=', $status, 'or');
            }
        } else {
            $contents->where('like_status', '=', $like_status[0]);
        }

        return (bool) $contents->count();
    }
}
