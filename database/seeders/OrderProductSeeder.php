<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get some orders and products
        $orders = Order::all();
        $products = Product::all();

        // Seed the order_product table
        foreach ($orders as $order) {
            // Randomly assign products to orders
            $productsForOrder = $products->random(3); // Randomly assign 3 products per order

            foreach ($productsForOrder as $product) {
                $order->products()->attach($product->id, [
                    'quantity' => rand(1, 5), // Random quantity between 1 and 5
                    'price' => $product->price // Use the product's price at the time of order
                ]);
            }
        }
    }
}
