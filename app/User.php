<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\OverrideResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'affil_hash', 'mailing_enabled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function is_admin()
    {
        return $this->is_admin == 1;
    }

    protected $attributes = array(
        'main_size' => '20971520', // 20MB
        'paid_size' => 0,
        'free_size' => '20971520' // 20MB
    );

    public function recalcSize()
    {
        $user_size = max($this->main_size + $this->paid_size, $this->ordered_unpaid_size);
        $used_size_project = Project::withTrashed()->where('user_id', $this->id)->join('project_files', 'projects.id', '=', 'project_files.project_id')->sum('filesize');
        $used_size_task = Project::withTrashed()->where('user_id', $this->id)
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

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function payment()
    {
        return $this->hasMany('App\Payment');
    }
}
