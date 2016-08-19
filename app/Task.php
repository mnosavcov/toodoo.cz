<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Task extends Model
{
    use SoftDeletes {
        forceDelete as traitForceDelete;
    }

    protected $dateFormat = 'U';

    protected $attributes = [
        'priority' => 0
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function status()
    {
        return $this->belongsTo('App\TaskStatus', 'task_status_id');
    }

    public function file()
    {
        return $this->hasMany('App\TaskFile');
    }

    public function key()
    {
        return $this->project->key . '-' . $this->task_id;
    }

    public function scopeByKey($query, $key)
    {
        list($project_key, $task_id) = explode('-', $key);
        $project = Project::byKey($project_key);
        if (!isset($project->id)) return $query->where(DB::raw('false'));
        return $query->where(['project_id' => $project->id, 'task_id' => $task_id])->first();
    }

    public function scopeHasStatus($query, $code)
    {
        return $query->where('task_status_id', TaskStatus::where('code', $code)->first(['id'])->id);
    }

    public function forceDelete()
    {
        $files = $this->file;
        foreach ($files as $file) {
            if (!$file->delete()) return false;
        }

        $user = User::find($this->project->user_id);
        $user->recalcSize();

        return $this->traitForceDelete();
    }
}
