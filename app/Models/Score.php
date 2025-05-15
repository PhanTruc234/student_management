<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'score',
    ];

    // Quan hệ với Student quan hệ 1
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Quan hệ với Subject quan hệ 1
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
