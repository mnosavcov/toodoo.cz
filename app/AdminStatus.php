<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminStatus extends Model
{
    protected $table="admin_status";

    protected $fillable = [
        'type',
        'data'
    ];
}
