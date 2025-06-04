<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ManageOrder extends Component
{
    use WithPagination;

    public $no_order, $description, $status, $orderId, $orderOwnerId, $price = 0;
    public $selectedProducts = [];
    public $productList = [];
    public $showForm = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'no_order' => 'required|string',
        'description' => 'required|string',
        'status' => 'required|string|in:waiting,printing,can_pick_up,picked_up',
        'orderOwnerId' => 'required|exists:users,id',
        'selectedProducts' => 'required|array|min:1',
        'selectedProducts.*.product_id' => 'required|exists:products,id',
        'selectedProducts.*.quantity' => 'required|integer|min:1',
        'selectedProducts.*.price' => 'required|numeric|min:0',
    ];

    protected $listeners = ['delete' => 'delete'];

    public function mount()
    {
        $this->status = 'waiting';
        $this->productList = Product::all();
        $this->selectedProducts = [];
    }

    public function render()
    {
        return view('livewire.manage-order', [
            'orders' => Order::with(['user', 'products', 'latestStatus'])
                ->orderByDesc('updated_at') // <-- This makes the latest updated/created order first
                ->paginate(10),
            'orderOwners' => User::all(),
            'products' => $this->productList,
        ]);
    }

    public function save()
    {
        $this->calculateTotal();
        $this->validate();

        if ($this->orderId) {
            // Update existing order
            $order = Order::findOrFail($this->orderId);
            $order->update([
                'no_order' => $this->no_order,
                'description' => $this->description,
                'price' => $this->price,
                'user_id' => $this->orderOwnerId,
                'status' => $this->status,
            ]);

            // Sync products
            $order->products()->detach();
            foreach ($this->selectedProducts as $product) {
                $order->products()->attach($product['product_id'], [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }
        } else {
            // Create new order
            $order = Order::create([
                'no_order' => $this->no_order,
                'description' => $this->description,
                'price' => $this->price,
                'user_id' => $this->orderOwnerId,
                'status' => $this->status,
            ]);

            foreach ($this->selectedProducts as $product) {
                $order->products()->attach($product['product_id'], [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }
        }

        $this->showForm = false;

        $this->resetInput();
        session()->flash('message', 'Order saved successfully!');
        $this->dispatch('orderSaved', message: 'Order saved successfully!');
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

        $this->showForm = true; // <-- This opens the modal
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
        $this->description = ''; // Use order_desc
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
        $this->calculateTotal();
    }

    public function updatedSelectedProducts($value, $name)
    {
        // $name example: "1.product_id"
        $parts = explode('.', $name);
        if (count($parts) === 2 && $parts[1] === 'product_id') {
            $index = $parts[0];
            $productId = $value;
            if ($productId) {
                $product = \App\Models\Product::find($productId);
                if ($product) {
                    $this->selectedProducts[$index]['quantity'] = 1;
                    $this->selectedProducts[$index]['price'] = $product->price ?? 0;
                }
            } else {
                $this->selectedProducts[$index]['quantity'] = 1;
                $this->selectedProducts[$index]['price'] = 0;
            }
        }
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->price = collect($this->selectedProducts)
            ->sum(function ($item) {
                return (float)($item['quantity'] ?? 0) * (float)($item['price'] ?? 0);
            });
    }

    public function countWaitingOrderCount()
    {
        return Order::where('status', 'waiting')->count();
    }

    public function showAddForm()
    {
        $this->resetInput(); // Optional: clear form fields
        $this->showForm = true;
    }

    public function hideForm()
    {
        $this->showForm = false;
    }
}
