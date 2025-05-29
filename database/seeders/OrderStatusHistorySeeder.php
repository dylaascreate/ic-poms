<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Database\Seeder;

class OrderStatusHistorySeeder extends Seeder
{
    public function run()
    {
        $statuses = ['waiting', 'printing', 'can_pick_up', 'picked_up'];

        $orders = Order::all();

        if ($orders->isEmpty()) {
            $this->command->info('No orders found, skipping order_status_histories seeding.');
            return;
        }

        foreach ($orders as $order) {
            // Optional: detach existing histories if you want fresh seeding
            $order->statusHistories()->delete();

            // Create between 1 and 4 status updates per order
            $count = rand(1, 4);

            // Generate timestamps starting a few days ago
            $startDate = now()->subDays(10);

            for ($i = 0; $i < $count; $i++) {
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => $statuses[min($i, count($statuses) - 1)], // progresses through statuses
                    'note' => null,
                    'changed_at' => $startDate->copy()->addDays($i * 2),
                ]);
            }
        }
    }
}
