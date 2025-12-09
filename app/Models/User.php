<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'name',
        'email',
        'avatar',
        'password',
        'role',
        'is_approved',
        'approved_by',
        'approved_at',
        'phone',
        'address',
        'birth_place',
        'birth_date',
        'gender',
        'occupation',
        'ktp_file',
        'is_ktp_verified',
        'ktp_verified_at',
        'ktp_verified_by',
        'verification_submitted_at',
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
        'password' => 'hashed',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'is_ktp_verified' => 'boolean',
        'ktp_verified_at' => 'datetime',
        'birth_date' => 'date',
        'verification_submitted_at' => 'datetime',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isContributor(): bool
    {
        return $this->role === 'contributor';
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approvedUsers()
    {
        return $this->hasMany(User::class, 'approved_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePendingApproval($query)
    {
        return $query->where('is_approved', false)->where('role', 'contributor');
    }

    public function ktpVerifier()
    {
        return $this->belongsTo(User::class, 'ktp_verified_by');
    }

    public function isKtpVerified(): bool
    {
        return $this->is_ktp_verified === true;
    }

    public function hasVerifiedKtp(): bool
    {
        if ($this->isSuperAdmin()) {
            return true; // Superadmin selalu verified
        }
        
        return $this->isKtpVerified();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    public function hasPermission(string $permissionName): bool
    {
        // Superadmin memiliki semua permission
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Check if permissions are already loaded
        if ($this->relationLoaded('permissions')) {
            return $this->permissions->contains('name', $permissionName);
        }

        return $this->permissions()->where('name', $permissionName)->exists();
    }

    public function hasAnyPermission(array $permissionNames): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Check if permissions are already loaded
        if ($this->relationLoaded('permissions')) {
            $userPermissionNames = $this->permissions->pluck('name')->toArray();
            return !empty(array_intersect($userPermissionNames, $permissionNames));
        }

        return $this->permissions()->whereIn('name', $permissionNames)->exists();
    }

    public function assignPermission(string $permissionName): void
    {
        $permission = Permission::where('name', $permissionName)->first();
        if ($permission && !$this->hasPermission($permissionName)) {
            $this->permissions()->attach($permission->id);
        }
    }

    public function revokePermission(string $permissionName): void
    {
        $permission = Permission::where('name', $permissionName)->first();
        if ($permission) {
            $this->permissions()->detach($permission->id);
        }
    }
}
