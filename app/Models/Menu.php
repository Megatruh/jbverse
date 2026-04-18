<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    // 1. Tambahkan 'slug' ke fillable
    protected $fillable = ['umkm_id', 'name', 'slug', 'category', 'description', 'images'];

    protected $casts = ['images' => 'array'];

    // Relasi (Tetap sama)
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
    public function variantCategories()
    {
        return $this->hasMany(VariantCategory::class);
    }
    public function menuCombinations()
    {
        return $this->hasMany(MenuCombination::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 2. Fungsi otomatis pembuat Slug
    protected static function booted()
    {
        static::creating(function ($menu) {
            $slug = Str::slug($menu->name);
            $originalSlug = $slug;
            $count = 1;

            // PERHATIAN: Pengecekan duplikat DIBATASI HANYA PADA umkm_id milik menu ini
            while (static::where('umkm_id', $menu->umkm_id)->where('slug', $slug)->exists()) {
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
