<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantCategory extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'name', 'is_required'];
    public function options()
    {
        return $this->hasMany(VariantOption::class);
    }
}
