<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderStatusHistory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ManageOrder extends Component
{
    use WithPagination;

    public $no_order, $description, $status, $orderId, $orderOwnerId, $price = 0;
    public $selectedProducts = [];
    public $productList = [];
    public $showForm = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'no_order' => 'required|string|max:20',
        'description' => 'required|string',
        'status' => 'required|string|in:waiting,printing,can_pick_up,picked_up',
        'status' => 'required|string|in:waiting,printing,can_pick_up,picked_up',
        'orderOwnerId' => 'required|exists:users,id',
        'selectedProducts' => 'required|array|min:1',
        'selectedProducts.*.product_id' => 'required|exists:products,id',
        'selectedProducts.*.quantity' => 'required|integer|min:1',
        'selectedProducts.*.price' => 'required|numeric|min:0',
    ];

    public $isProduction = false;

    public function mount()
    {
        $this->status = 'waiting';
        $this->productList = Product::all();
        $this->isProduction = Auth::user()->position === 'Production Staff'; // Adjust field name if needed
        $this->selectedProducts = [];
    }


    public function render()
    {
        $data['orders'] = Order::get(); // Get all orders
        return view('livewire.manage-order', [
            'orders' => Order::with(['user', 'products', 'latestStatus'])
                ->orderByDesc('updated_at') // <-- This makes the latest updated/created order first
                ->paginate(10),
            'orderOwners' => User::all(),
            'products' => $this->productList,
        ]);
    }

    // SAVE method
    public function save()
    {
        // Check if the user is a production staff
        $isProduction = Auth::user()->position === 'Production Staff'; // Adjust if role field differs

        if ($isProduction && $this->orderId) {
            // Only allow status update
            $order = Order::findOrFail($this->orderId);

            if ($order->status !== $this->status) {
                $order->update(['status' => $this->status]);

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => $this->status,
                ]);

                $this->dispatch('orderSaved', message: 'Order status updated successfully.');
            } else {
                $this->dispatch('orderSaved', message: 'No changes to status.');
            }

            return;
        }

        // Validate as usual for non-production staff
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

        if (empty($this->no_order)) {
            $this->dispatch('orderError', message: 'Order number cannot be empty.');
            return;
        }

    if ($this->orderId) {
        // Update existing order by ID
        $order = Order::findOrFail($this->orderId);
        $order->update([
            'no_order' => $this->no_order,
            'description' => $this->description,
            'status' => $this->status,
            'user_id' => $this->orderOwnerId,
            'price' => $this->price,
        ]);
    } else {
        // Create new order
        $order = Order::create([
            'no_order' => $this->no_order,
            'description' => $this->description,
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

    // Sync products
    $order->products()->sync($productData);

    $this->showForm = false;
    $this->dispatch('orderSaved', message: 'Order saved successfully!');
}


    public function edit($id)
    {
        $order = Order::with('products')->findOrFail($id);

        $this->orderId = $order->id;
        $this->no_order = $order->no_order;
        $this->description = $order->description;
        $this->status = $order->status;
        $this->orderOwnerId = $order->user_id;
        $this->price = $order->price;

        $this->selectedProducts = [];
        foreach ($order->products as $product) {
            $this->selectedProducts[] = [
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
            ];
        }

        $this->showForm = true;
    }

    // public function delete($id)
    // {
    //     Order::findOrFail($id)->delete();
    //     $this->dispatch('orderSaved', message: 'Order deleted successfully.');
    // }

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


    public function updatedSelectedProducts($value, $key)
    {
        if (str_ends_with($key, 'product_id')) {
            [$index,] = explode('.', $key);
            $product = Product::find($value);
            if ($product) {
                $this->selectedProducts[$index]['price'] = $product->price;
            }
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

    #[On('delete')]
    public function delete($id){
        $order = Order::find($id);
        $order->delete();
        session()->flash('message', 'Order Deleted Successfully.');
        $this->dispatch('orderSaved', message:'Order Deleted Successfully.');

//     public function showAddForm()
//     {
//         $this->resetInput(); // Optional: clear form fields
//         $this->showForm = true;
//     }

//     public function hideForm()
//     {
//         $this->showForm = false;
//     }
}
