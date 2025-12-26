<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'title',
        'description',
        'duration_hours',
        'status',
        'trainer_id',
        'video_url',
        'pdf_file'
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // students enrolled
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withTimestamps();
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }


}
