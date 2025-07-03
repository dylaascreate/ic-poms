<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;

class Dashboard extends Component
{
    public $filterStatus = null;
    public $searchOrderNo = '';

    public function filterOrders($status)
    {
        $this->filterStatus = $status;
    }

    public function updatingSearchOrderNo()
    {
        $this->resetPage(); // Optional if using pagination
    }

    public function render()
    {
        $orders = Order::query();

        if ($this->filterStatus) {
            $orders->where('status', $this->filterStatus);
        }

        if ($this->searchOrderNo) {
            $orders->where('no_order', 'like', '%' . $this->searchOrderNo . '%');
        }

        return view('livewire.admin.dashboard', [
            'orders' => $orders->latest()->get(),
            'totalOrders' => Order::count(),
            'waitingOrders' => Order::where('status', 'waiting')->count(),
            'printingOrders' => Order::where('status', 'printing')->count(),
            'readyOrders' => Order::where('status', 'can_pick_up')->count(),
            'pickedUpOrders' => Order::where('status', 'picked_up')->count(),
        ]);
    }
}



