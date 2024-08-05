<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'photo',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student')->withTimestamps();
    }
}
