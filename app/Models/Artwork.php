<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artwork extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'competition_id',
    'title',
    'description',
    'image_path',
    'art_style', 
    'score',
    'feedback',
    'status',
    'graded_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Artwork belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Artwork belongs to a Student (User with role = student)
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id')
                    ->where('role', 'student');
    }

    // Artwork belongs to a Competition
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function grader()
    {
    return $this->belongsTo(User::class, 'graded_by');
    }

    // Artwork has one Certificate
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    // Artwork can have multiple payments
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
}