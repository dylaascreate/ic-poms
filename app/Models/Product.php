<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image', // assuming you added this field
    ];

    // A product belongs to many orders
    public function orders()
    {
        return $this->belongsToMany(Order::class)
                    ->withPivot('quantity', 'price') // price at time of order
                    ->withTimestamps();
    }
}
