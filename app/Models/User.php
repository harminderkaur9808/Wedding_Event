<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'first_name',
        'last_name',
        'email',
        'password',
        'family_relation',
        'role',
        'is_admin',
        'is_approved',
        'phone',
        'address',
        'date_of_birth',
        'status',
        'last_login_at',
        'profile_image',
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
            'is_admin' => 'boolean',
            'is_approved' => 'boolean',
            'date_of_birth' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true || $this->role === 'admin';
    }

    /**
     * Check if user is simple user
     */
    public function isSimpleUser(): bool
    {
        return $this->role === 'simpleuser' && !$this->is_admin;
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the media for the user
     */
    public function media()
    {
        return $this->hasMany(UserMedia::class);
    }

    /**
     * Questions asked by the user (Ask the Host).
     */
    public function askTheHostQueries()
    {
        return $this->hasMany(AskTheHostQuery::class);
    }

    /**
     * Replies posted by the user (Ask the Host).
     */
    public function askTheHostReplies()
    {
        return $this->hasMany(AskTheHostReply::class);
    }
}
