<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get locations and products
        $locations = Location::all();
        $products = Product::all();

        // Define sample quantities for each location and product
        $sampleQuantities = [
            'Provinsi Jawa Timur' => ['Product A' => 8, 'Product B' => 8, 'Product C' => 3],
            'Kabupaten Madiun' => ['Product A' => 5, 'Product B' => 4, 'Product C' => 1],
            'Kabupaten Pacitan' => ['Product A' => 3, 'Product B' => 4, 'Product C' => 2],
            'Kecamatan Dopo' => ['Product A' => 2, 'Product B' => 1, 'Product C' => 0],
            'Kecamatan Geger' => ['Product A' => 3, 'Product B' => 3, 'Product C' => 1],
            'Kecamatan Arjosari' => ['Product A' => 2, 'Product B' => 3, 'Product C' => 1],
            'Desa Munggut' => ['Product A' => 5, 'Product B' => 3, 'Product C' => 2],
        ];

        foreach ($locations as $location) {
            foreach ($products as $product) {
                // Assign quantity if defined in the sampleQuantities array, otherwise assign 0
                $quantity = $sampleQuantities[$location->name][$product->name] ?? 0;

                $location->products()->attach($product->id, ['quantity' => $quantity]);
            }
        }
    }
}
