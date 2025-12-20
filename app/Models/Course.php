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
        'ai_description',
        'duration_hours',
        'status'
    ];
}
