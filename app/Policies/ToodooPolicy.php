<?php

namespace App\Policies;

use App\User;
use App\Project;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToodooPolicy
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

    public function updateProject(User $user, Project $project)
    {
        return $user->id === $project->user_id;
    }

    public function updateTask(User $user, Task $task)
    {
        return $user->id === $task->project->user_id;
    }
}
