<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Products ke saath relationship (Agar aapne banaya hai)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}