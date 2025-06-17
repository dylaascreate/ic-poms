<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public $orders;
    public $totalOrders;
    public $waitingOrders;
    public $printingOrders;
    public $readyOrders;
    public $pickedUpOrders;

  
    public function mount()
{
    $userId = Auth::id();

    $this->orders = Order::with(['products', 'user']) // Add 'user' for display
        ->where('user_id', $userId)
        ->get();

    $this->totalOrders = $this->orders->count();
    $this->waitingOrders = $this->orders->where('status', 'waiting')->count();
    $this->printingOrders = $this->orders->where('status', 'printing')->count();
    $this->readyOrders = $this->orders->where('status', 'can_pick_up')->count();
    $this->pickedUpOrders = $this->orders->where('status', 'picked_up')->count();
}


    public function render()
    {
        return view('livewire.auth.user-dashboard', [
            'totalOrders' => $this->totalOrders,
            'waitingOrders' => $this->waitingOrders,
            'printingOrders' => $this->printingOrders,
            'readyOrders' => $this->readyOrders,
            'pickedUpOrders' => $this->pickedUpOrders,
            'orders' => $this->orders,
        ]);
    }

    
}


?>
