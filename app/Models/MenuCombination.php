<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCombination extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'price'];

    // Mengambil data opsi apa saja yang ada di kombinasi ini
    public function options()
    {
        return $this->belongsToMany(VariantOption::class, 'combination_details', 'combination_id', 'variant_option_id');
    }
}
