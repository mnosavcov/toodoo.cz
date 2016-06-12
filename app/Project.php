<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
