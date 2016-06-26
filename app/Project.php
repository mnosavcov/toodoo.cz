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
    
    public function todoCount() {
        return $this->tasks()->hasStatus('TODO')->count();
    }

    public function inprogressCount() {
        return $this->tasks()->hasStatus('IN-PROGRESS')->count();
    }
}
