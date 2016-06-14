<?php

namespace App\Policies;

use App\User;
use App\Project;

class ToodooPolicy
{
    public function updateProject(User $user, Project $project)
    {
        return $user->id === $project->user_id;
    }
}
