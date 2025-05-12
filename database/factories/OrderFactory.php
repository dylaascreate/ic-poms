<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Creating an order with a random user and some random products
        return [
            'user_id' => User::factory(),  // This creates a new user for each order
            'name' => $this->faker->word(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 500), // Random price between 10 and 500
        ];
    }

    /**
     * Define the relationship with products
     */
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            // Attach random products to the order with quantity and price
            $products = Product::inRandomOrder()->take(3)->get(); // Get 3 random products

            foreach ($products as $product) {
                $order->products()->attach($product->id, [
                    'quantity' => $this->faker->numberBetween(1, 5), // Random quantity between 1 and 5
                    'price' => $product->price, // Use the price of the product
                ]);
            }
        });
    }
}
