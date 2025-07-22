<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'professor_id',
        'year',
        'day',
        'time',
        'duration',
        'room',
        'max_students',
        'enrolled_students',
        'date',
    ];

    protected $casts = [
        'time' => 'datetime:H:i',
        'date' => 'date',
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}