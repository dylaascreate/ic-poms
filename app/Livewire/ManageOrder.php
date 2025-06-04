<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ManageOrder extends Component
{
    use WithPagination;

    public $no_order, $description, $status, $orderId, $orderOwnerId, $price;
    public $selectedProducts = []; // [product_id => ['quantity' => x, 'price' => y]]
    public $productList = [];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'no_order' => 'required|string',
        'description' => 'required|string',
        'status' => 'required|string|in:waiting,printing,ready,picked_up',
        'selectedProducts' => 'required|array|min:1',
        'selectedProducts.*.product_id' => 'required|exists:products,id',
        'selectedProducts.*.quantity' => 'required|integer|min:1',
        'selectedProducts.*.price' => 'required|numeric|min:0',
    ];


    public function mount()
    {
        $this->status = 'waiting';
        $this->productList = Product::all();
    }

    public function render()
    {
        return view('livewire.manage-order', [
            'orders' => Order::with(['user', 'products', 'latestStatus'])->paginate(10),
            'orderOwners' => User::all(),
            'products' => $this->productList,
        ]);
    }

    // SAVE method
    public function save()
    {
        $this->validate();

        $ownerId = $this->orderOwnerId ?? Auth::id();

        $this->price = 0;
        $productData = [];

        foreach ($this->selectedProducts as $product) {
            $this->price += $product['quantity'] * $product['price'];
            $productData[$product['product_id']] = [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ];
        }

        $data = [
            'no_order' => $this->no_order,
            'description' => $this->description,
            'price' => $this->price,
            'status' => $this->status,
            'user_id' => $ownerId,
        ];

        if ($this->orderId) {
            $order = Order::findOrFail($this->orderId);
            $order->update($data);
        } else {
            $order = Order::create($data);
        }

        $order->products()->sync($productData);

        $lastStatus = $order->latestStatus?->status ?? null;
        if ($lastStatus !== $this->status) {
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $this->status,
            ]);
        }

        $this->dispatch('orderSaved', message: 'Order saved successfully.');
        $this->resetInput();
    }


    public function edit($id)
    {
        $order = Order::with('products')->findOrFail($id);

        $this->orderId = $order->id;
        $this->no_order = $order->no_order;
        $this->description = $order->description;
        $this->price = $order->price;
        $this->status = $order->status;
        $this->orderOwnerId = $order->user_id;

        $this->selectedProducts = [];

        foreach ($order->products as $product) {
            $this->selectedProducts[] = [
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
            ];
        }
    }


    public function delete($id)
    {
        Order::findOrFail($id)->delete();
        $this->dispatch('orderSaved', message: 'Order deleted successfully.');
    }

    public function resetInput()
    {
        $this->orderId = null;
        $this->no_order = '';
        $this->description = '';
        $this->price = 0;
        $this->status = 'waiting';
        $this->orderOwnerId = null;
        $this->selectedProducts = [];
    }

    public function addProduct()
    {
        $this->selectedProducts[] = [
            'product_id' => '',
            'quantity' => 1,
            'price' => 0.00
        ];
    }

    public function removeProduct($index)
    {
        unset($this->selectedProducts[$index]);
        $this->selectedProducts = array_values($this->selectedProducts);
    }

    // Optional helper to update product selection dynamically (add/remove)
    public function updatedSelectedProducts($value, $key)
    {
        // You can add validation or auto-calculation here if needed
    }

    public function countWaitingOrderCount()
{
    return Order::where('status', 'waiting')->count();
}

}
