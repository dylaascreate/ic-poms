<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ManageOrder extends Component
{
    use WithPagination;

    public $no_order, $description, $status, $orderId, $orderOwnerId, $price;
    public $selectedProducts = []; // [product_id => ['quantity' => x, 'price' => y]]
    public $productList = [];
    public $searchOrderNo = '';
    public $filterStatus = null; // Stores the selected status for filtering

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'no_order' => 'required|string|max:20',
        'description' => 'required|string',
        'status' => 'required|string|in:waiting,printing,can_pick_up,picked_up',
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
        $this->isProduction = Auth::user()->position === 'Production Staff';
    }

    public function search()
{
    $this->resetPage();
}
public function clearSearch()
{
    $this->searchOrderNo = '';
    $this->resetPage();
}


    public function filterOrders($status)
    {
        $this->filterStatus = $status;
    }

   public function render()
{
    $query = Order::with(['user', 'products']);

    // Apply search first
    if (!empty($this->searchOrderNo)) {
        $query->where('no_order', 'like', '%' . $this->searchOrderNo . '%');
    }

    // Then filter status if selected
    if (!empty($this->filterStatus)) {
        $query->where('status', $this->filterStatus);
    }

    return view('livewire.manage-order', [
        'orders' => $query->latest()->paginate(10),
        'orderOwners' => User::all(),
        'products' => $this->productList,
    ]);
}



    public function save()
    {
        $isProduction = Auth::user()->position === 'Production Staff';

        if ($isProduction && $this->orderId) {
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

    #[On('delete')]
    public function delete($id)
    {
        $order = Order::find($id);
        $order->delete();
        session()->flash('message', 'Order Deleted Successfully.');
        $this->dispatch('orderSaved', message:'Order Deleted Successfully.');
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

    public function updatedSelectedProducts($value, $key)
    {
        if (str_ends_with($key, 'product_id')) {
            [$index,] = explode('.', $key);
            $product = Product::find($value);
            if ($product) {
                $this->selectedProducts[$index]['price'] = $product->price;
            }
        }

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
