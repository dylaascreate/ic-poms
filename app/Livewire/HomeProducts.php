<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class HomeProducts extends Component
{
    public function render()
    {
        return view('livewire.home-products', [
            'products' => Product::latest()->take(12)->get() // adjust limit as needed
        ]);
    }
}