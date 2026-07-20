<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clean data safely using imported Schema Facade
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Parent Categories create karein
        $essentials = Category::create([
            'name' => 'Inelastic (Necessities)', 
            'slug' => 'inelastic-necessities'
        ]);
        
        $luxuries = Category::create([
            'name' => 'Elastic (Luxuries)', 
            'slug' => 'elastic-luxuries'
        ]);

        // 3. All 10 items mapped with correct category IDs
        $products = [
            // ====== INELASTIC GOODS (Necessities) ======
            [
                'name' => 'Rice',
                'price' => 150.00,
                'category_id' => $essentials->id,
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=600&auto=format&fit=crop&q=60',
                'description' => 'Premium Quality Organic Basmati Rice. High in demand, everyday household necessity.',
                'stock' => 500,
                'views_today' => 0,
                'is_elastic' => false,
            ],
            [
                'name' => 'Petrol',
                'price' => 280.00,
                'category_id' => $essentials->id,
                'image' => 'https://images.unsplash.com/photo-1527018601619-a508a2be00cd?w=600&auto=format&fit=crop&q=60',
                'description' => 'Octane fuel for transportation. Highly inelastic necessity for daily commute.',
                'stock' => 1000,
                'views_today' => 0,
                'is_elastic' => false,
            ],
            [
                'name' => 'Life-Saving Medicine',
                'price' => 120.00,
                'category_id' => $essentials->id,
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=600&auto=format&fit=crop&q=60',
                'description' => 'Essential healthcare antibiotics. Completely inelastic as consumers cannot compromise on survival.',
                'stock' => 300,
                'views_today' => 0,
                'is_elastic' => false,
            ],
            [
                'name' => 'Cooking Oil',
                'price' => 450.00,
                'category_id' => $essentials->id,
                'image' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=600&auto=format&fit=crop&q=60',
                'description' => 'Premium refined cooking oil. Core kitchen ingredient with inelastic demand across households.',
                'stock' => 400,
                'views_today' => 0,
                'is_elastic' => false,
            ],

            // ====== ELASTIC GOODS (Luxuries & Substitutes) ======
            [
                'name' => 'Luxury Watch',
                'price' => 25000.00,
                'category_id' => $luxuries->id,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=60',
                'description' => 'Elegant minimalist luxury timepiece. Elastic demand based on elite status.',
                'stock' => 10,
                'views_today' => 0,
                'is_elastic' => true,
            ],
            [
                'name' => 'Smartphone',
                'price' => 45000.00,
                'category_id' => $luxuries->id,
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=60',
                'description' => 'Latest flagship smartphone with bezel-less display. Highly elastic tech product.',
                'stock' => 50,
                'views_today' => 0,
                'is_elastic' => true,
            ],
            [
                'name' => 'Gaming Console',
                'price' => 85000.00,
                'category_id' => $luxuries->id,
                'image' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=600&auto=format&fit=crop&q=60',
                'description' => 'Next-gen entertainment console. High price elasticity; non-essential leisure luxury.',
                'stock' => 25,
                'views_today' => 0,
                'is_elastic' => true,
            ],
            [
                'name' => 'Gourmet Coffee Beans',
                'price' => 1200.00,
                'category_id' => $luxuries->id,
                'image' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=600&auto=format&fit=crop&q=60',
                'description' => 'Artisanal roasted coffee beans. Highly elastic since buyers can switch to tea if prices rise.',
                'stock' => 150,
                'views_today' => 0,
                'is_elastic' => true,
            ],
            [
                'name' => 'Designer Jacket',
                'price' => 18000.00,
                'category_id' => $luxuries->id,
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&auto=format&fit=crop&q=60',
                'description' => 'Premium leather luxury wear. Highly fashion-elastic; demand drops significantly with inflation.',
                'stock' => 30,
                'views_today' => 0,
                'is_elastic' => true,
            ],
            [
                'name' => 'Custom Gaming PC',
                'price' => 150000.00,
                'category_id' => $luxuries->id,
                'image' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?w=600&auto=format&fit=crop&q=60',
                'description' => 'Ultimate workstation and gaming rig. Ultra-luxury elastic asset for enthusiast markets.',
                'stock' => 12,
                'views_today' => 0,
                'is_elastic' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
      // Category ke hisaab se array banayein
$essentials_names = ['Organic Rice', 'Refined Cooking Oil', 'Wheat Flour', 'Table Salt', 'Clean Water Gallon', 'Basic Antibiotics', 'Daily Multivitamins', 'Face Mask Pack'];
$luxury_names = ['Ultra-Wide Monitor', 'Noise-Cancelling Headphones', 'Silk Bedding Set', 'Espresso Machine', 'Mechanical Keyboard', 'Leather Wallet', 'Smart Home Hub', 'Wireless Charger'];

for ($i = 1; $i <= 40; $i++) {
            $isElastic = (bool)rand(0, 1);
            
            // Name logic yahan aa jayegi...
            $name = $isElastic ? $luxury_names[array_rand($luxury_names)] : $essentials_names[array_rand($essentials_names)];

            Product::create([
                'name' => $name . ' ' . rand(10, 99),
                'price' => $isElastic ? rand(5000, 90000) : rand(50, 500),
                'category_id' => $isElastic ? $luxuries->id : $essentials->id,
                
                // YAHAN PAR REPLACE KAREIN:
               'image' => 'https://picsum.photos/seed/' . rand(1, 1000) . '/600/600',
                
                'description' => 'Premium quality item optimized for EcoSphere demand cycles.',
                'stock' => rand(10, 500),
                'views_today' => rand(0, 100),
                'is_elastic' => $isElastic,
            ]);
        }
    }
}