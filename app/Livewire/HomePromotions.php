<?php
// app/Livewire/HomePromotions.php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Promotion;

class HomePromotions extends Component
{
    public function render()
    {
        return view('livewire.home-promotions', [
            'promotions' => Promotion::latest()->get(),
        ]);
    }
}