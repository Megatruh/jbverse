<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // PERUBAHAN: Ganti umkm_id jadi menu_id
    protected $fillable = [
        'user_id',
        'menu_id', 
        'rating', 
        'comment'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // PERUBAHAN: Relasi diubah ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
