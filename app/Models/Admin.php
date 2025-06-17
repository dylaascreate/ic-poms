<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'position', // new column
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Constants for admin positions
    public const ADMIN_POSITIONS = [
        'superadmin',
        'designer',
        'manager',
        'marketing',
        'production staff',
    ];

    /**
     * Check if the admin has a specific position.
     */
    public function hasPosition(string $position): bool
    {
        return $this->position === $position;
    }
}
