<?php

namespace App\Policies;

use App\User;
use App\Project;

class ProjectPolicy
{
    public function update(User $user, Project $project)
    {
        return $user->id === $project->user_id;
    }
}
