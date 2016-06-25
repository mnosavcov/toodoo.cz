<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\TaskStatus;

class Task extends Model
{
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

	public function scopeKey($query)
	{
		return $this->project->key.'-'.$this->task_id;
	}

    public function scopeByKey($query, $key)
    {
	    list($project_key, $task_id) = explode('-', $key);
	    $project = Project::byKey($project_key);
        return $query->where(['project_id' => $project->id, 'task_id' => $task_id])->first();
    }

	public function scopeHasStatus($query, $code)
	{
		return $query->where('task_status_id', TaskStatus::where('code', $code)->first(['id'])->id);
	}
}
