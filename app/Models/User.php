<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role as RoleEnum;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    /**
     * Get the orders associated with the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function resumes(): HasMany
    {
        return $this->hasMany(Resume::class);
    }

    /**
     * Roles assigned to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole(RoleEnum|string $role): bool
    {
        $value = $role instanceof RoleEnum ? $role->value : $role;

        return $this->roles()->where('name', $value)->exists();
    }

    public function assignRole(RoleEnum|string $role): void
    {
        $value     = $role instanceof RoleEnum ? $role->value : $role;
        $roleModel = Role::query()->firstOrCreate(['name' => $value]);

        $this->roles()->syncWithoutDetaching([$roleModel->id]);
    }

    /**
     * Set a single role for the user (replaces all existing roles).
     */
    public function setRole(RoleEnum|string $role): void
    {
        $value     = $role instanceof RoleEnum ? $role->value : $role;
        $roleModel = Role::query()->firstOrCreate(['name' => $value]);

        $this->roles()->sync([$roleModel->id]);
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
