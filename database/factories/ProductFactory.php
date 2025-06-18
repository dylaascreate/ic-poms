<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'image' => $this->faker->imageUrl(640, 480, 'business', true),
            'category' => $this->faker->randomElement([
                'Business Card',
                'Flyer',
                'Poster',
                'Sticker',
                'Brochure',
                'Banner',
                'T-Shirt Printing',
                'Mug Printing',
            ]),
        ];
    }

}
