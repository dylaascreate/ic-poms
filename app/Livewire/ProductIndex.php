<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;

class ProductIndex extends Component
{
    public function render()
    {
        return view('livewire.product-index', [
            'products' => Product::paginate(2),
        ]);
    }
}
