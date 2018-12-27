<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Status;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //destroy方法, 是需要检查user的id就是要删除的发帖用户id
    //还要再写具体的policy
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
}
