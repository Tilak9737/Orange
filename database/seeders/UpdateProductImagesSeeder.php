<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class UpdateProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'outerwear' => [
                'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800',
                'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=800',
                'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?q=80&w=800',
            ],
            't-shirts' => [
                'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800',
                'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=800',
                'https://images.unsplash.com/photo-1576566582419-17de88ecd5ec?q=80&w=800',
            ],
            'accessories' => [
                'https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=800',
                'https://images.unsplash.com/photo-1521335629791-ce4aec67dd15?q=80&w=800',
                'https://images.unsplash.com/photo-1590736704728-f4730bb30770?q=80&w=800',
            ],
            'footwear' => [
                'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800',
                'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?q=80&w=800',
                'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=800',
            ],
            'default' => [
                'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=800',
            ]
        ];

        $products = Product::get();
        $count = 0;

        /** @var Product $product */
        foreach ($products as $product) {
            // Check if product has any images via the relationship
            if ($product->images()->count() === 0) {
                $categorySlug = $product->category ? $product->category->slug : 'default';
                $pool = $images[$categorySlug] ?? $images['default'];
                $imagePath = $pool[array_rand($pool)];

                // Create ProductImage record
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $imagePath,
                    'is_primary' => true
                ]);

                $this->command->info("Added image to: {$product->name}");
                $count++;
            }
        }

        $this->command->info("Total images added: {$count}");
    }
}
