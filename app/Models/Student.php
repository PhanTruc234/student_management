<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'email',
        'gender',
        'dob',
    ];
    // Quan hệ nhiều-nhiều
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
    // có nhiều 
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    // có nhiều 
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}