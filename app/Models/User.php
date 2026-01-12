<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'status'
    ];

    public function courses()
    {
        // return $this->belongsToMany(Course::class)->withTimestamps();
        return $this->belongsToMany(Course::class, 'course_students')->withTimestamps();
    }

     // student enrolled courses
     public function enrolledCourses()
     {
        //  return $this->belongsToMany(Course::class, 'course_user')
         return $this->belongsToMany(Course::class, 'course_students')
             ->withTimestamps();
     }

     public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, 'student_id');
    }
}
