<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $fillable = [
        'committee_type',
        'year',
        'name',
        'image',
        'club_position',
        'varsity_position',
        'facebook_link',
        'linkedin_link'
    ];
}