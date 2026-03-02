<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Coupon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@orange.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Create Regular User
        User::updateOrCreate(
            ['email' => 'customer@orange.test'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // 3. Create Categories
        $categories = [
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'description' => 'Jackets, coats, and hoodies to keep you warm with style.'],
            ['name' => 'T-Shirts', 'slug' => 't-shirts', 'description' => 'Premium graphic and blank tees in various fits.'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Caps, bags, and chains to complete your look.'],
            ['name' => 'Footwear', 'slug' => 'footwear', 'description' => 'Sneakers and boots built for comfort and durability.'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Create Products
        $products = [
            [
                'category_id' => $categoryModels['outerwear']->id,
                'name' => 'Orange Flare Varsity Jacket',
                'description' => 'A classic varsity silhouette with a modern oversized fit. Features premium wool body, genuine leather sleeves, and custom chenille patches. The signature piece of our Core Collection.',
                'price' => 249.99,
                'sale_price' => null,
                'stock' => 15,
                'featured' => true,
                'rating_avg' => 4.8,
            ],
            [
                'category_id' => $categoryModels['outerwear']->id,
                'name' => 'Gradient Tech Windbreaker',
                'description' => 'Lightweight, water-resistant nylon shell with a striking orange to sunset-red gradient. Waterproof zippers and hidden hood.',
                'price' => 129.99,
                'sale_price' => 99.99,
                'stock' => 45,
                'featured' => true,
                'rating_avg' => 4.5,
            ],
            [
                'category_id' => $categoryModels['t-shirts']->id,
                'name' => 'Heavyweight Box Tee - Solar',
                'description' => 'Our signature 280gsm heavyweight cotton tee in a washed solar orange. Dropped shoulders, wide collar, and a perfectly boxy crop.',
                'price' => 45.00,
                'sale_price' => null,
                'stock' => 100,
                'featured' => false,
                'rating_avg' => 5.0,
            ],
            [
                'category_id' => $categoryModels['accessories']->id,
                'name' => 'Velocity Shield Sunglasses',
                'description' => 'Retro-futuristic shield frames in matte black with reflective orange polarized lenses. Includes hard case and microfiber cloth.',
                'price' => 85.00,
                'sale_price' => null,
                'stock' => 30,
                'featured' => true,
                'rating_avg' => 4.2,
            ],
            [
                'category_id' => $categoryModels['footwear']->id,
                'name' => 'Apex Runners v2',
                'description' => 'Ultra-responsive cushioning meets breathable mesh. The Apex v2 features a bold orange colorway with synthetic overlays for locked-in support.',
                'price' => 160.00,
                'sale_price' => 129.50,
                'stock' => 5,
                'featured' => false,
                'rating_avg' => 4.9,
            ]
        ];

        $stockImages = [
            'outerwear' => [
                'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800&auto=format&fit=crop', // Jacket
                'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=800&auto=format&fit=crop' // Leather jacket
            ],
            't-shirts' => [
                'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800&auto=format&fit=crop', // Blank tee
            ],
            'accessories' => [
                'https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=800&auto=format&fit=crop', // Sunglasses
            ],
            'footwear' => [
                'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop', // Orange Nike shoes
            ]
        ];

        foreach ($products as $p) {
            $p['slug'] = Str::slug($p['name']);
            $product = Product::updateOrCreate(['slug' => $p['slug']], $p);

            // Add stock image based on category
            $categorySlug = Category::find($product->category_id)->slug;
            $imageUrl = $stockImages[$categorySlug][0] ?? 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=800&auto=format&fit=crop'; // Default clothing store image

            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'is_primary' => true],
                ['path' => $imageUrl]
            );
        }

        // 5. Create a Coupon
        Coupon::updateOrCreate(
            ['code' => 'HEATWAVE20'],
            [
                'type' => 'percentage',
                'value' => 20.00,
                'min_order' => 50.00,
                'uses_left' => 100,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'WELCOME10'],
            [
                'type' => 'fixed',
                'value' => 10.00,
                'min_order' => 0.00,
                'uses_left' => null, // unlimited
            ]
        );

    }
}
