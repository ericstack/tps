<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /** Admins can act on any task; otherwise only the assigned employee may. */
    public function manage(User $user, Task $task): bool
    {
        return $user->isAdmin()
            || ($user->employee_id !== null && $user->employee_id === $task->employee_id);
    }
}
