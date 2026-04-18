<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Umkm extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'contact_number', 'description', 'is_open', 'image_banner'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Menu::class);
    }

    // 2. Fungsi otomatis pembuat Slug saat data disimpan
    protected static function booted()
    {
        static::creating(function ($umkm) {
            $slug = Str::slug($umkm->name);
            $originalSlug = $slug;
            $count = 1;

            // Cek apakah slug sudah ada di database (untuk mencegah duplikat)
            while (static::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-" . $count++;
            }

            $umkm->slug = $slug;
        });
    }

    // 3. Ubah kunci pencarian URL default Laravel dari 'id' menjadi 'slug'
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
