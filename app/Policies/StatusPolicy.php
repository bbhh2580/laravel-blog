<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the status.
     *
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function destroy(User $user, Status $status): bool
    {
        return $user->id === $status->user_id;
    }
}
