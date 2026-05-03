<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    // 1. Tambahkan 'slug' ke fillable
    // Ubah baris fillable menjadi seperti ini:
    protected $fillable = [
        'umkm_id', 'name', 'slug', 'category', 'description',
        'image', 'ukuran', 'variant', 'price'
    ];

    // Relasi (Tetap sama)
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 2. Fungsi otomatis pembuat Slug
    protected static function booted()
    {
        static::creating(function ($menu) {
            // Jika slug sudah diset manual, biarkan.
            if (!empty($menu->slug)) {
                return;
            }
            $slug = Str::slug($menu->name);
            $originalSlug = $slug;
            $count = 1;

            // PERHATIAN: Pengecekan duplikat DIBATASI HANYA PADA umkm_id milik menu ini
            while (
                static::where('umkm_id', '=', $menu->umkm_id, 'and')
                    ->where('slug', '=', $slug, 'and')
                    ->exists()
            ) {
                $slug = "{$originalSlug}-" . $count++;
            }

            $menu->slug = $slug;
        });
    }
    
    // 3. Ubah kunci pencarian URL
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
