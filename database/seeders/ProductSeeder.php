<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'Laptop Lenovo ThinkPad X1 Carbon',
                'description' => 'Laptop bisnis premium dengan prosesor Intel Core i7, RAM 16GB, dan SSD 512GB.',
                'price' => 23000000,
                'stock' => 10,
                'image_path' => 'images/products/thinkpad-x1-carbon.jpg',
            ],
            [
                'title' => 'Asus ROG Strix G15',
                'description' => 'Laptop gaming dengan prosesor AMD Ryzen 7 dan GPU RTX 4060.',
                'price' => 28000000,
                'stock' => 8,
                'image_path' => 'images/products/asus-rog-strix-g15.jpg',
            ],
            [
                'title' => 'iPhone 15 Pro Max',
                'description' => 'Smartphone flagship dengan chipset A17 Pro dan kamera 48MP.',
                'price' => 25000000,
                'stock' => 15,
                'image_path' => 'images/products/iphone-15-pro-max.jpg',
            ],
            [
                'title' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Smartphone Android dengan layar Dynamic AMOLED 2X dan kamera 200MP.',
                'price' => 24000000,
                'stock' => 12,
                'image_path' => 'images/products/samsung-s24-ultra.jpg',
            ],
            [
                'title' => 'Sony WH-1000XM5',
                'description' => 'Headphone wireless noise-cancelling terbaik di kelasnya.',
                'price' => 5500000,
                'stock' => 25,
                'image_path' => 'images/products/sony-wh-1000xm5.jpg',
            ],
        ];

        DB::table('products')->insert($products);
    }
}
