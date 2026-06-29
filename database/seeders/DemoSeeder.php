<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::create(['name' => 'Electronics']);
        $clothing    = Category::create(['name' => 'Clothing']);
        $books       = Category::create(['name' => 'Books']);

        Product::insert([
            ['category_id' => $electronics->id, 'name' => 'Wireless Headphones', 'price' => 89.99,  'active' => true,  'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $electronics->id, 'name' => 'Mechanical Keyboard',  'price' => 149.00, 'active' => true,  'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $electronics->id, 'name' => 'USB-C Hub',            'price' => 39.50,  'active' => false, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $clothing->id,    'name' => 'Merino Wool Sweater',  'price' => 65.00,  'active' => true,  'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $clothing->id,    'name' => 'Slim Chinos',          'price' => 49.95,  'active' => true,  'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $books->id,       'name' => 'Clean Code',           'price' => 34.99,  'active' => true,  'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $books->id,       'name' => 'Designing Data-Intensive Applications', 'price' => 54.99, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
