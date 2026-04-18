<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $fillable = ['user_id', 'name', 'contact_number', 'description', 'is_open', 'image_banner'];

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

    // PERUBAHAN BESAR DI SINI:
    // Toko memiliki banyak ulasan "Melalui" Menu
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Menu::class);
    }

    // Fungsi kalkulasi rating toko tetap bekerja seperti biasa!
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
