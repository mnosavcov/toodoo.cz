<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;

class Project extends Model
{
    use SoftDeletes {
        forceDelete as traitForceDelete;
    }

    protected $dateFormat = 'U';

    protected $attributes = [
        'priority' => 0
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function participant()
    {
        return $this->belongsToMany('App\User', 'project_participant', 'project_id', 'user_id')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function file()
    {
        return $this->hasMany('App\ProjectFile');
    }

    public function scopeByKey($query, $key, $owner = null)
    {
        if ($owner) {
            $user_id = null;
            $user = User::where('email', $owner)->first();
            if ($user) $user_id = $user->id;
            return $query->where(['user_id' => $user_id, 'key' => $key])
                ->whereHas('participant', function ($query) {
                    $query->where('user_id', Auth::id());
                });
        } else {
            return $query->where(['user_id' => Auth::id(), 'key' => $key]);
        }
    }

    public function scopeNavList($query)
    {
        return $query
            ->where(function ($query) {
                $query->where('projects.user_id', Auth::id())
                    ->orWhereHas('participant', function ($query) {
                        $query->where('user_id', Auth::id());
                    });
            })
            ->leftJoin('tasks', 'tasks.project_id', '=', 'projects.id')
            ->leftJoin('task_statuses as todo', function ($join) {
                $join->on('todo.id', '=', 'tasks.task_status_id')->where('todo.code', '=', 'TODO');
            })
            ->leftJoin('task_statuses as inprogress', function ($join) {
                $join->on('inprogress.id', '=', 'tasks.task_status_id')->where('inprogress.code', '=', 'IN-PROGRESS');
            })
            ->groupBy('projects.id')
            ->orderByRaw('if((count(todo.id)>0 or count(inprogress.id>0)), 1, 0) desc')
            ->orderBy('projects.priority', 'desc')
            ->orderBy('projects.name', 'asc')
            ->select('projects.*');
    }


    public function todoCount()
    {
        return $this->tasks()->hasStatus('TODO')->count();
    }

    public function inprogressCount()
    {
        return $this->tasks()->hasStatus('IN-PROGRESS')->count();
    }

    public function forceDelete()
    {
        $files = $this->file;
        foreach ($files as $file) {
            if (!$file->delete()) return false;
        }

        $tasks = $this->tasks;
        foreach ($tasks as $task) {
            if (!$task->forceDelete()) return false;
        }

        $user = User::find($this->user_id);
        if ($user) {
            $user->recalcSize();
        }

        return $this->traitForceDelete();
    }

    public function owner()
    {
        if ($this->user_id == Auth::id()) return null;
        return $this->user->email;
    }
}
