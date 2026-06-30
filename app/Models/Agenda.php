<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
    'event_id',
    'start_time',
    'end_time',
    'topic'
];
}
