<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Allow mass assignment for these new columns
    protected $fillable = [
    'category_id', // <-- Yeh line yahan add karein
    'name',
    'price',
    'image',
    'description',
    'stock',
    'views_today', 
    'is_elastic'
];

    // Ensure these are treated as numbers/floats for calculation
    protected $casts = [
        'price' => 'float',
        'views_today' => 'integer',
        'is_elastic' => 'boolean',
    ];
// app/Models/Product.php

public function getNameAttribute()
{
    $locale = app()->getLocale();
    $column = 'name_' . $locale;

    // Agar Urdu/Chinese column exist karta hai aur empty nahi hai
    if (in_array($locale, ['ur', 'zh']) && isset($this->{$column})) {
        return $this->{$column};
    }

    // Agar 'name' column hai toh wo return karo, 
    // agar error aa raha hai toh check karein table mein column ka naam kya hai!
    return $this->attributes['name'] ?? 'No Name'; 
}
}