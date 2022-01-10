<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_name',
        'date',
        'location',
        'information',
        'start_time',
        'end_time',
        'review'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'tasks')->withPivot('status');
    }
}
