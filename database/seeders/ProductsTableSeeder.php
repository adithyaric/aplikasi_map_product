<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['Product A', 'Product B', 'Product C'];

        foreach ($products as $product) {
            Product::create(['name' => $product]);
        }
    }
}
