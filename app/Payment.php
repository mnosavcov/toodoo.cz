<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $dateFormat = 'U';

    public function order()
    {
        return $this->morphedByMany('App\Order', 'pay')->withTimestamps();
    }
}
