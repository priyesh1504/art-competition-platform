<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'age',
        'is_active',
        'deactivation_requested',
        'failed_login_attempts',
        'is_locked',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'age' => 'integer',
        'is_active' => 'boolean',
        'deactivation_requested' => 'boolean',
        'failed_login_attempts' => 'integer',
        'is_locked' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Caregiver → Many Students
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'caregiver_student',
            'caregiver_id',
            'student_id'
        );
    }

    /**
     * Student → Many Caregivers
     */
    public function caregivers()
    {
        return $this->belongsToMany(
            User::class,
            'caregiver_student',
            'student_id',
            'caregiver_id'
        );
    }

    /**
     * Student → Many Artworks
     */
    public function artworks()
    {
        return $this->hasMany(Artwork::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is caregiver
     */
    public function isCaregiver()
    {
        return $this->role === 'caregiver';
    }

    /**
     * Check if user is student
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }
}