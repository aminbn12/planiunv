<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'type',
        'status',
        'request_date',
        'completion_date',
        'reason',
        'copies',
    ];

    protected $casts = [
        'request_date' => 'date',
        'completion_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}