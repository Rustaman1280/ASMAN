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
        'name',
        'email',
        'password',
        'role',
        'jurusan_id',
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

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Role Checks
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isGuruJurusan()
    {
        return $this->role === 'guru_jurusan';
    }

    public function isWakilKepsek()
    {
        return $this->role === 'wakil_kepsek';
    }

    public function isKepalaSekolah()
    {
        return $this->role === 'kepala_sekolah';
    }

    public function isBendahara()
    {
        return $this->role === 'bendahara';
    }

    // Permissions
    public function canEdit()
    {
        return in_array($this->role, ['admin', 'guru_jurusan', 'wakil_kepsek']);
    }

    public function canManageUsers()
    {
        return $this->role === 'admin';
    }
}
