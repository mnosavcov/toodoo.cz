<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
	protected $dateFormat = 'U';

	protected $table = 'task_statuses';
}
