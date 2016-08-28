<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $dateFormat = 'U';

    public function scopebyUserId($query, $user_id) {
        return $query->where('user_id', $user_id);
    }

    public function scopeOpened($query) {
        return $query->whereNotIn('status', ['complete', 'cancelled']);
    }
}
