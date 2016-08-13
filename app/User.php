<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'affil_hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function is_admin()
    {
        return $this->is_admin == 1;
    }

    protected $attributes = array(
        'main_size' => '20971520', // 20MB
        'purchased_size' => 0,
        'free_size' => '20971520' // 20MB
    );

    public function recalcSize()
    {
        $user_size = $this->main_size + $this->purchased_size;
        $used_size_project = Project::where('user_id', $this->id)->join('project_files', 'projects.id', '=', 'project_files.project_id')->sum('filesize');
        $used_size_task = Project::where('user_id', $this->id)
            ->join('tasks', 'projects.id', '=', 'tasks.project_id')
            ->join('task_files', 'tasks.id', '=', 'task_files.task_id')->sum('filesize');

        $used_size = $used_size_project + $used_size_task;

        $this->used_size = $used_size;
        $this->free_size = $user_size - $used_size;
        $this->save();

        return redirect()->route('account.detail');
    }

    public function projects()
    {
        return $this->hasMany('App\Project');
    }
}
