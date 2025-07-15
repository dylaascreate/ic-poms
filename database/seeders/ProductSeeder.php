<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category' => 'Business Card',
                'name' => 'Premium Business Card',
                'description' => 'High-quality matte finish business cards, 300gsm.',
                'price' => 25.00,
                'image' => 'business-card.png',
            ],
            [
                'category' => 'Business Card',
                'name' => 'Glossy Business Card',
                'description' => 'Gloss laminated cards for a shiny finish.',
                'price' => 30.00,
                'image' => 'business-card-glossy.png',
            ],
            [
                'category' => 'Flyer',
                'name' => 'A5 Promo Flyer',
                'description' => 'Perfect for promotions and handouts.',
                'price' => 15.00,
                'image' => 'flyer-a5.png',
            ],
            [
                'category' => 'Flyer',
                'name' => 'A4 Event Flyer',
                'description' => 'High-res event flyer for posters or mailers.',
                'price' => 20.00,
                'image' => 'flyer-a4.png',
            ],
            [
                'category' => 'Poster',
                'name' => 'A3 Poster Print',
                'description' => 'Ideal for indoor advertisements.',
                'price' => 18.00,
                'image' => 'poster-a3.png',
            ],
            [
                'category' => 'Poster',
                'name' => 'A2 Full Color Poster',
                'description' => 'Bright, vivid color poster prints.',
                'price' => 35.00,
                'image' => 'poster-a2.png',
            ],
            [
                'category' => 'Sticker',
                'name' => 'Round Logo Sticker',
                'description' => 'Waterproof, full-color round stickers.',
                'price' => 10.00,
                'image' => 'sticker-round.png',
            ],
            [
                'category' => 'Sticker',
                'name' => 'Label Sheet Sticker',
                'description' => 'Custom label sheets for packaging.',
                'price' => 12.00,
                'image' => 'sticker-label.png',
            ],
            [
                'category' => 'Brochure',
                'name' => 'Tri-fold Brochure',
                'description' => 'Folded brochures for marketing use.',
                'price' => 40.00,
                'image' => 'brochure-trifold.png',
            ],
            [
                'category' => 'Brochure',
                'name' => 'Bi-fold Brochure',
                'description' => 'Compact and clean layout brochure.',
                'price' => 35.00,
                'image' => 'brochure-bifold.png',
            ],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
