<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',        // 'user' or 'admin'
        'position',    // 'customer', 'manager', etc.
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials.
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Role checks
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Position Constants
     */
    public const USER_DEFAULT_POSITION = 'customer';
    public const ADMIN_DEFAULT_POSITION = 'production staff';

    public const ADMIN_POSITIONS = [
        'superadmin',
        'designer',
        'manager',
        'marketing',
        'production staff',
    ];

    public const ALL_POSITIONS = [
        self::USER_DEFAULT_POSITION,
        self::ADMIN_DEFAULT_POSITION,
        ...self::ADMIN_POSITIONS,
    ];
}
