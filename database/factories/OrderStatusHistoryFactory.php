<?php

namespace Database\Factories;

use App\Models\OrderStatusHistory;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusHistoryFactory extends Factory
{
    protected $model = OrderStatusHistory::class;

    public function definition()
    {
        $statuses = ['waiting', 'printing', 'can_pick_up', 'picked_up'];

        return [
            'order_id' => Order::factory(), // creates a related Order if none provided
            'status' => $this->faker->randomElement($statuses),
            'note' => $this->faker->optional()->sentence(),
            'changed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
