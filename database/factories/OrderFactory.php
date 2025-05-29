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
        return [
            'user_id' => User::factory(),
            'no_order' => strtoupper($this->faker->bothify('ORD###???')), // e.g. ORD123ABC
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->randomElement([
                'waiting',
                'printing',
                'can_pick_up',
                'picked_up'
            ]),
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
