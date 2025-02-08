<?php

namespace App\Services;

use App\Models\Location;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LocationService
{
    public $routeName;

    public function getLocationProductMapping($type, $parentId, $routeName)
    {
        $this->routeName = $routeName;
        $locations = Location::where('type', $type)
            ->when($parentId, fn ($query) => $query->where('parent_id', $parentId))
            ->with(['products', 'children.children.children.children.products'])
            ->get();

        return $locations->map(function ($location) {
            $allProducts = $this->getAllProducts($location);
            $totalQuantity = $allProducts->sum('pivot.quantity');

            $productsData = $allProducts->groupBy('id')->mapWithKeys(function ($group, $productId) use ($totalQuantity) {
                $productName = $group->first()->name;
                $quantity = $group->sum('pivot.quantity');
                $percentage = $totalQuantity > 0 ? round(($quantity / $totalQuantity) * 100, 2) : 0;

                return [$productName => "$percentage% - $quantity item"];
            });

            return [
                'id' => $location->id,
                'name' => $location->name,
                'data' => $productsData,
                'coordinates' => json_decode($location->coordinates),
                'color' => $this->getColor($totalQuantity),
                'nextRoute' => route($this->routeName, [
                    'type' => $this->getNextRoute($location->type),
                    'parentId' => $location->id,
                ]),
                'children' => $location->children->map(fn ($child) => [
                    'id' => $child->id,
                    'name' => $child->name,
                    'type' => $child->type,
                ]),
            ];
        });
    }

    public function getChartData($type, $id = null, $startDate = null, $endDate = null)
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        $locations = Location::where('type', $type)
            ->when($id, fn ($query) => $query->where('id', $id))
            ->with(['products', 'children.children.children.children.products'])
            ->get();

        return $locations->map(function ($location) use ($colors, $startDate, $endDate) {
            $allProducts = $this->getAllProducts($location);

            // Filter products data by date range
            $filteredProducts = $allProducts->filter(function ($product) use ($startDate, $endDate) {
                // Convert the date in 'pivot' to Carbon instance
                $productDate = \Carbon\Carbon::parse($product->pivot->date);

                // Apply the date filter (only include products within the range)
                return (! $startDate || $productDate->gte(\Carbon\Carbon::parse($startDate))) &&
                    (! $endDate || $productDate->lte(\Carbon\Carbon::parse($endDate)));
            });

            // Group and sum the filtered products data
            $productsData = $filteredProducts->groupBy('name')->map(fn ($group) => $group->sum('pivot.quantity'));

            // Generate colors for each product
            $productColors = [];
            foreach ($productsData->keys() as $index => $name) {
                $productColors[$name] = $colors[$index % count($colors)];
            }

            return [
                'name' => $location->name,
                'data' => $productsData,
                'colors' => $productColors,
            ];
        });
    }

    public function getLeaderboard()
    {
        $products = Product::select('id', 'name')->get();
        $leaderboardQuery = User::select('users.id', 'users.name', DB::raw('SUM(location_product.quantity) as total_sales'))
            ->join('location_product', function ($join) {
                $join->on('users.id', '=', 'location_product.user_id')
                    ->join('products', fn ($productJoin) => $productJoin->on('location_product.product_id', '=', 'products.id')
                        ->whereNull('products.deleted_at'));
            })
            ->where('users.role', 'sales')
            ->groupBy('users.id', 'users.name');

        foreach ($products as $product) {
            $leaderboardQuery->addSelect(DB::raw("SUM(CASE WHEN location_product.product_id = {$product->id} THEN location_product.quantity ELSE 0 END) as product_{$product->id}"));
        }

        return $leaderboardQuery->orderByDesc('total_sales')->limit(10)->get();
    }

    public function getProductLeaderboard($locationType = null, $locationId = null)
    {
        $products = Product::select('id', 'name')
            ->whereNull('deleted_at')
            ->get();

        $leaderboardQuery = Location::select('locations.id', 'locations.name', DB::raw('SUM(location_product.quantity) as total_sales'))
            ->join('location_product', function ($join) {
                $join->on('locations.id', '=', 'location_product.location_id')
                    ->join('products', function ($productJoin) {
                        $productJoin->on('location_product.product_id', '=', 'products.id')
                            ->whereNull('products.deleted_at');
                    });
            });

        // TODO Filter by locations
        // // Apply filters if provided
        // if ($locationType && $locationId) {
        //     $leaderboardQuery->where(function ($query) use ($locationId) {
        //         $query->where('locations.parent_id', $locationId)
        //             ->orWhere('locations.id', $locationId);
        //     })->where('locations.type', $locationType);
        // }

        $leaderboardQuery->groupBy('locations.id', 'locations.name');

        foreach ($products as $product) {
            $leaderboardQuery->addSelect(DB::raw("SUM(CASE WHEN location_product.product_id = {$product->id} THEN location_product.quantity ELSE 0 END) as product_{$product->id}"));
        }

        return $leaderboardQuery->orderByDesc('total_sales')->limit(10)->get();
    }

    private function getAllProducts($location)
    {
        switch ($location->type) {
            case 'dusun':
                return $location->products;
            case 'desa':
                return $location->children->flatMap->products;
            case 'kecamatan':
                return $location->children->flatMap(fn ($child) => $child->children->flatMap->products);
            case 'kabupaten':
                return $location->children->flatMap(fn ($child) => $child->children->flatMap(fn ($grandChild) => $grandChild->children->flatMap->products));
            case 'provinsi':
                return $location->children->flatMap(fn ($child) => $child->children->flatMap(fn ($grandChild) => $grandChild->children->flatMap(fn ($greatGrandChild) => $greatGrandChild->children->flatMap->products)));
            default:
                return collect();
        }
    }

    private function getColor($totalQuantity)
    {
        // Define color thresholds
        $colors = [
            0 => '#ff0000',
            100 => '#7ad9ff',
            500 => '#1696c9',
        ];

        // Find the appropriate color based on the thresholds
        foreach ($colors as $threshold => $color) {
            if ($totalQuantity <= $threshold) {
                return $color;
            }
        }

        // Default color if above all thresholds
        return '#035e82'; // Blue
    }

    private function getnextRoute($type)
    {
        $next = [
            'provinsi' => 'kabupaten',
            'kabupaten' => 'kecamatan',
            'kecamatan' => 'desa',
            'desa' => 'dusun',
            'dusun' => ' ',
        ];

        return $next[$type] ?? null;
    }
}
