<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'venue',
        'start_datetime',
        'end_datetime',
        'registration_fee',
        'prerequisites',
        'registration_link',
        'banner_image',
        'status',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];
    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    public function highlights()
    {
        return $this->hasMany(Highlight::class);
    }
}
