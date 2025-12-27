<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_id','student_id','total_questions','correct','wrong','score_percent','submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function quiz() { return $this->belongsTo(Quiz::class); }
    public function student() { return $this->belongsTo(User::class, 'student_id'); }
    public function answers() { return $this->hasMany(QuizAttemptAnswer::class, 'attempt_id'); }

}
