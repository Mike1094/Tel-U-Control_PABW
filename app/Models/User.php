<?php

namespace App\Models;

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
        'password',
        'role',
        'sub_role',
        'phone',
        'nim_nip',
        'avatar',
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
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is satpam
     */
    public function isSatpam(): bool
    {
        return $this->role === 'satpam';
    }

    /**
     * Check if user is civitas (dosen or mahasiswa)
     */
    public function isCivitas(): bool
    {
        return $this->role === 'civitas';
    }

    /**
     * Check if user is warga
     */
    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    /**
     * Check if civitas is dosen
     */
    public function isDosen(): bool
    {
        return $this->role === 'civitas' && $this->sub_role === 'dosen';
    }

    /**
     * Check if civitas is mahasiswa
     */
    public function isMahasiswa(): bool
    {
        return $this->role === 'civitas' && $this->sub_role === 'mahasiswa';
    }

    /**
     * Get display role name
     */
    public function getDisplayRoleAttribute(): string
    {
        if ($this->role === 'civitas' && $this->sub_role) {
            return ucfirst($this->sub_role);
        }
        return ucfirst($this->role);
    }

    /**
     * Get role badge color
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            'admin' => 'danger',
            'satpam' => 'warning',
            'civitas' => 'info',
            'warga' => 'success',
            default => 'secondary',
        };
    }

    // Relationships
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function lostFoundItems()
    {
        return $this->hasMany(LostFoundItem::class);
    }

    public function trafficUpdates()
    {
        return $this->hasMany(TrafficUpdate::class);
    }

    public function notificationLogs()
    {
        return $this->hasMany(NotificationLog::class);
    }
}
