<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
    ];

    // An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order has many products through the pivot table
    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity', 'price') // price at time of order
                    ->withTimestamps();
    }
}
