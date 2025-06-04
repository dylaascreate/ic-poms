<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order; // Make sure you have an Order model

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalOrders' => Order::count(),
            'waitingOrders' =>Order::where('status', 'waiting')->count(),
            'printingOrders' => Order::where('status', 'printing')->count(),
            'pickedUpOrders' => Order::where('status', 'picked_up')->count(),
            'readyOrders' => Order::where('status', 'can_pick_up')->count(),
            'orders' => Order::with('product', 'user')->latest()->take(10)->get(), // Get latest 10 orders, or use paginate if you want

        ]);
    }

}

