<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Order;

class OrderUser extends Component
{
    use WithFileUploads;

    public $productId;
    public $productName;
    public $quantity = 1;
    public $customer_name;
    public $size;
    public $file;
    public $lamination = 'No';
    public $material;
    public $colour = 'Black';
    public $details;

    public $materialOptions = ['Glossy', 'Matte', 'Recycled'];
    public $colourOptions = ['Black', 'Colour'];
    public $laminationOptions = ['Yes', 'No'];

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->productName = Product::find($productId)?->name ?? 'Unknown Product';
    }

    public function submit()
    {
        $this->validate([
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'size' => 'nullable|string|max:100',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamination' => 'required|in:Yes,No',
            'material' => 'required|string',
            'colour' => 'required|in:Black,Colour',
            'details' => 'nullable|string|max:500',
        ]);

        $filePath = $this->file->store('orders');

        Order::create([
            'product_id' => $this->productId,
            'quantity' => $this->quantity,
            'customer_name' => $this->customer_name,
            'size' => $this->size,
            'file' => $filePath,
            'lamination' => $this->lamination,
            'material' => $this->material,
            'colour' => $this->colour,
            'details' => $this->details,
        ]);

        session()->flash('message', 'Order placed successfully');

        $this->reset([
            'quantity', 'customer_name', 'size', 'file',
            'lamination', 'material', 'colour', 'details'
        ]);

        return redirect('/products');
    }

    public function render()
    {
        return view('livewire.order-user');
    }
}
