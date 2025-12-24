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
    return $this->belongsToMany(\App\Models\Course::class)->withTimestamps();
}
}
