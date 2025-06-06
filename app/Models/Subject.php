<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'credit'];
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
