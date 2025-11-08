<?php

namespace App\Models;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $guarded = ['created_at', 'deleted_at',];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        "is_you",
        "role_name"
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->roles()->first();
    }

    public function getIsYouAttribute(): bool
    {
        return $this->id == auth()->user()->id;
    }

    public function getRoleNameAttribute(): string | Closure
    {
        return $this->getRoleNames()->get(0);
    }

    public function getAllPermissionNames(): array
    {
        return $this->getAllPermissions()->pluck('name')->toArray() ?? [];
    }

}
