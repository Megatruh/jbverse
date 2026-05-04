<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Umkm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Fungsi otomatis pembuat Slug saat data disimpan
    protected static function booted()
    {
        static::creating(function ($umkm) {
            $slug = Str::slug($umkm->name);
            $originalSlug = $slug;
            $count = 1;

            // REVISI: Menggunakan query() agar Intelephense tidak error
            while (static::query()->where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-" . $count++;
            }

            $umkm->slug = $slug;
        });
    }

    // --- RELASI ---
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Menu::class, 'umkm_id', 'menu_id', 'id', 'id');
    }

    // Atribut buatan untuk menghitung rata-rata rating
    public function getAverageRatingAttribute()
    {
        return $this->menus()->withAvg('reviews', 'rating')->get()->avg('reviews_avg_rating') ?? 0;
    }
}