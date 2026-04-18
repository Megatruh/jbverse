<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['umkm_id', 'name', 'category', 'description', 'images'];
    protected $casts = ['images' => 'array'];

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

    // TAMBAHAN: Relasi ke tabel reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // TAMBAHAN: Fungsi untuk menghitung rating spesifik menu ini
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
