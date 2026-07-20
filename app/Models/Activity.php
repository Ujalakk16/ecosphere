<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    // Is table mein hum ye columns store karenge
    protected $fillable = [
        'user_id', 
        'action'
    ];

    // Relationship: Har activity kisi ek user ki hoti hai
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}