<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Competition extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'title',
        'description',
        'rules',
        'start_date',
        'deadline',
        'status',
        'fee',
        'created_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'start_date' => 'datetime',
        'deadline'   => 'datetime',
        'fee'        => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    // Competition is ongoing
    public function isOpen()
    {
        if (!$this->start_date || !$this->deadline) {
            return false;
        }

        return now()->startOfDay()->between(
            $this->start_date->startOfDay(),
            $this->deadline->endOfDay()
        );
    }

    // Competition has not started yet
    public function isUpcoming()
    {
        if (!$this->start_date) {
            return false;
        }

        return now()->startOfDay()->lt($this->start_date->startOfDay());
    }

    // Competition deadline passed
    public function isCompleted()
    {
        if (!$this->deadline) {
            return false;
        }

        return now()->startOfDay()->gt($this->deadline->endOfDay());
    }

    /*
    |--------------------------------------------------------------------------
    | Automatically Determine Status
    |--------------------------------------------------------------------------
    */
    public function getComputedStatusAttribute()
    {
        if ($this->status === 'cancelled') {
            return 'cancelled';
        }

        if ($this->isUpcoming()) {
            return 'upcoming';
        }

        if ($this->isOpen()) {
            return 'ongoing';
        }

        if ($this->isCompleted()) {
            return 'completed';
        }

        return 'upcoming';
    }
}