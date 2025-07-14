<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions = [
            [
                'title' => 'Summer Sale',
                'description' => 'Enjoy up to 30% off on selected products this summer!',
                'image' => 'default-img.png',
            ],
            [
                'title' => 'New Product Launch',
                'description' => 'Introducing our latest brochure printing service with glossy finish!',
                'image' => 'default-img.png',
            ],
            [
                'title' => 'Limited-Time Offer',
                'description' => 'Get free delivery on orders above RM100 until the end of this month!',
                'image' => 'default-img.png',
            ],
        ];

        foreach ($promotions as $promo) {
            Promotion::create($promo);
        }
    }
}
