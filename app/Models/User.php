<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'slug',
        'password',
        'role',
        'status',
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

    // 2. Tambahkan Fungsi Validasi Hak Akses
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPengusaha(): bool
    {
        return $this->role === 'pengusaha' && $this->status === 'approved';
    }

    // 3. Relasi ke UMKM
    public function umkm()
    {
        return $this->hasOne(Umkm::class);
    }

    //Fungsi otomatis pembuat Slug saat registrasi
    protected static function booted()
    {
        static::creating(function ($user) {
            $slug = Str::slug($user->name);
            $originalSlug = $slug;
            $count = 1;

            // Cek duplikat slug user di database
            while (static::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-" . $count++;
            }

            $user->slug = $slug;
        });
    }

    //Ubah pencarian default URL menjadi slug
    public function getRouteKeyName()
    {
        return 'slug';
    }}
