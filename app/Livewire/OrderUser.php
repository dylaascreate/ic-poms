<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;

class OrderUser extends Component
{
    public $productId;
    public $productName;
    public $quantity = 1;
    public $customer_name;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->productName = Product::find($productId)->name;
    }

    public function submit()
    {
        $this->validate([
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
        ]);

        Order::create([
            'product_id' => $this->productId,
            'quantity' => $this->quantity,
            'customer_name' => $this->customer_name,
        ]);

        session()->flash('message', 'Order placed successfully');
        return redirect('/products'); //Redirets to the products page after order is placed
    }

    public function render()
    {
        return view('livewire.order-user');
    }
}
