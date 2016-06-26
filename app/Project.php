<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Project extends Model
{
    protected $dateFormat = 'U';

    protected $attributes = [
        'priority' => 0
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function scopeByKey($query, $key)
    {
        return $query->where(['user_id' => Auth::user()->id, 'key' => $key])->first();
    }

    public function scopeNavList($query)
    {
        $projects = $query
            ->where('projects.user_id', Auth::user()->id)
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

        return $projects->get();
    }


    public function todoCount()
    {
        return $this->tasks()->hasStatus('TODO')->count();
    }

    public function inprogressCount()
    {
        return $this->tasks()->hasStatus('IN-PROGRESS')->count();
    }
}
