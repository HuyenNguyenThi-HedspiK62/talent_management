<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'instructor',
        'max_score'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['score', 'comment']);
    }
}
