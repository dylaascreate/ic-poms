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

    public $no_order, $description, $status = 'waiting', $orderId, $orderOwnerId, $price = 0;
    public $selectedProducts = [];
    public $productList = [];
    public $isProduction = false;

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'no_order' => 'required|string|max:20|unique:orders,no_order,' . $this->orderId,
            'description' => 'required|string',
            'status' => 'required|in:waiting,printing,can_pick_up,picked_up',
            'orderOwnerId' => 'required|exists:users,id',
            'selectedProducts' => 'required|array|min:1',
            'selectedProducts.*.product_id' => 'required|exists:products,id',
            'selectedProducts.*.quantity' => 'required|integer|min:1',
            'selectedProducts.*.price' => 'required|numeric|min:0',
        ];
    }

    public function mount()
    {
        $this->productList = Product::all();
        $this->isProduction = Auth::user()?->position === 'Production Staff';
    }

    public function render()
    {
        return view('livewire.manage-order', [
            'orders' => Order::with(['user', 'products', 'latestStatus'])->latest()->paginate(10),
            'orderOwners' => User::where('role', 'user')->get(),
            'products' => $this->productList,
        ]);
    }

    public function save()
    {
        $user = Auth::user();

        // Production staff can only update status
        if ($this->isProduction && $this->orderId) {
            $order = Order::findOrFail($this->orderId);

            if ($order->status !== $this->status) {
                $order->update(['status' => $this->status]);

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => $this->status,
                ]);

                $this->dispatch('orderSaved', ['message' => 'Order status updated successfully.']);
            } else {
                $this->dispatch('orderSaved', ['message' => 'No changes made.']);
            }
            return;
        }

        // Validation for others
        $this->validate();

        $ownerId = $this->orderOwnerId ?? $user->id;
        $productData = [];
        $this->price = 0;

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
            'status' => $this->status,
            'user_id' => $ownerId,
            'price' => $this->price,
        ];

        $order = $this->orderId ? Order::findOrFail($this->orderId) : new Order();
        $order->fill($data)->save();
        $order->products()->sync($productData);

        if ($order->latestStatus?->status !== $this->status) {
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $this->status,
            ]);
        }

        $msg = $this->orderId ? 'Order updated successfully.' : 'Order created successfully.';
        $this->dispatch('orderSaved', ['message' => $msg]);
        $this->resetInput();
    }

    public function edit($id)
    {
        $order = Order::with('products')->findOrFail($id);

        $this->orderId = $order->id;
        $this->no_order = $order->no_order;
        $this->description = $order->description;
        $this->status = $order->status;
        $this->price = $order->price;
        $this->orderOwnerId = $order->user_id;

        $this->selectedProducts = $order->products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
            ];
        })->toArray();
    }

    #[On('delete')]
    public function delete($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            $this->dispatch('orderSaved', ['message' => 'Order deleted successfully.']);
        } else {
            $this->dispatch('orderError', ['message' => 'Order not found.']);
        }
    }

    public function resetInput()
    {
        $this->orderId = null;
        $this->no_order = '';
        $this->description = '';
        $this->status = 'waiting';
        $this->orderOwnerId = null;
        $this->selectedProducts = [];
        $this->price = 0;
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
        $this->recalculateTotal();
    }

    public function updatedSelectedProducts($value, $key)
    {
        if (str_ends_with($key, 'product_id')) {
            [$index, ] = explode('.', $key);
            $product = Product::find($value);
            if ($product) {
                $this->selectedProducts[$index]['price'] = $product->price;
            }
        }
        $this->recalculateTotal();
    }

    private function recalculateTotal()
    {
        $this->price = 0;
        foreach ($this->selectedProducts as $product) {
            if (isset($product['quantity'], $product['price'])) {
                $this->price += $product['quantity'] * $product['price'];
            }
        }
    }

    public function countWaitingOrderCount()
    {
        return Order::where('status', 'waiting')->count();
    }
}
