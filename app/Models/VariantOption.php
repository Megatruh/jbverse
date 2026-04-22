<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantOption extends Model
{
    protected $fillable = ['variant_category_id', 'name'];
    // Relasi pivot ke MenuCombination
    public function combinations() { return $this->belongsToMany(MenuCombination::class, 'combination_details', 'variant_option_id', 'combination_id'); }
}
