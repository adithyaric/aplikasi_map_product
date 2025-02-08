<?php

namespace App\Services;

use App\Models\Location;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LocationService
{
    public function getLocationProductMapping($type, $parentId)
    {
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
                'nextRoute' => route('locations', [
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

    public function getChartData($request)
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        $tanggal = $request->query('tanggal');
        if ($tanggal) {
            [$startDate, $endDate] = explode(' - ', $tanggal);
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
        } else {
            $startDate = Carbon::minValue();
            $endDate = Carbon::maxValue();
        }

        $query = DB::table('location_product')
            ->join('products', 'location_product.product_id', '=', 'products.id')
            ->join('locations as dusun', 'location_product.location_dusun_id', '=', 'dusun.id')
            ->join('locations as desa', 'location_product.location_desa_id', '=', 'desa.id')
            ->join('locations as kecamatan', 'location_product.location_kecamatan_id', '=', 'kecamatan.id')
            ->join('locations as kabupaten', 'location_product.location_kabupaten_id', '=', 'kabupaten.id')
            ->join('locations as provinsi', 'location_product.location_provinsi_id', '=', 'provinsi.id')
            ->whereBetween('location_product.date', [$startDate, $endDate]);

        foreach (['location_provinsi_id', 'location_kabupaten_id', 'location_kecamatan_id', 'location_desa_id', 'location_dusun_id'] as $filter) {
            if ($request->query($filter)) {
                $query->where("location_product.$filter", $request->query($filter));
            }
        }

        $results = $query->select(
            'provinsi.name as provinsi_name',
            'kabupaten.name as kabupaten_name',
            'kecamatan.name as kecamatan_name',
            'desa.name as desa_name',
            'dusun.name as dusun_name',
            'products.name as product_name',
            DB::raw('SUM(location_product.quantity) as total_quantity')
        )
            ->groupBy(
                'provinsi.name',
                'kabupaten.name',
                'kecamatan.name',
                'desa.name',
                'dusun.name',
                'products.name'
            )
            ->get();

        $groupedData = $results->groupBy('provinsi_name')->map(function ($group, $provinsiName) use ($colors) {
            $productData = $group->groupBy('product_name')->map(fn ($productGroup) => $productGroup->sum('total_quantity'));

            $productColors = [];
            foreach ($productData->keys() as $index => $name) {
                $productColors[$name] = $colors[$index % count($colors)];
            }

            return [
                'name' => $provinsiName,
                'data' => $productData,
                'colors' => $productColors,
            ];
        });

        return response()->json($groupedData->values());
    }

    public function getLeaderboard($request)
    {
        $tanggal = $request->query('tanggal');
        if ($tanggal) {
            [$startDate, $endDate] = explode(' - ', $tanggal);
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
        } else {
            $startDate = Carbon::minValue();
            $endDate = Carbon::maxValue();
        }

        $products = Product::select('id', 'name')->get();

        $leaderboardQuery = User::select('users.id', 'users.name', DB::raw('SUM(location_product.quantity) as total_sales'))
            ->join('location_product', function ($join) {
                $join->on('users.id', '=', 'location_product.user_id')
                    ->join('products', fn ($productJoin) => $productJoin->on('location_product.product_id', '=', 'products.id')
                        ->whereNull('products.deleted_at'));
            })
            ->where('users.role', 'sales')
            ->whereBetween('location_product.date', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name');

        foreach ($products as $product) {
            $leaderboardQuery->addSelect(DB::raw("SUM(CASE WHEN location_product.product_id = {$product->id} THEN location_product.quantity ELSE 0 END) as product_{$product->id}"));
        }

        return $leaderboardQuery->orderByDesc('total_sales')->limit(10)->get();
    }

    public function getProductLeaderboard($request)
    {
        $tanggal = $request->query('tanggal');
        if ($tanggal) {
            [$startDate, $endDate] = explode(' - ', $tanggal);
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
        } else {
            $startDate = Carbon::minValue();
            $endDate = Carbon::maxValue();
        }

        $products = Product::select('id', 'name')
            ->whereNull('deleted_at')
            ->get();

        $leaderboardQuery = DB::table('location_product')
            ->join('locations', 'locations.id', '=', 'location_product.location_dusun_id')
            ->join('products', function ($join) {
                $join->on('location_product.product_id', '=', 'products.id')
                    ->whereNull('products.deleted_at');
            })
            ->whereBetween('location_product.date', [$startDate, $endDate])
            ->select('locations.id', 'locations.name', DB::raw('SUM(location_product.quantity) as total_sales'))
            ->groupBy('locations.id', 'locations.name');

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
        $colors = [
            0 => '#ff0000',
            100 => '#7ad9ff',
            500 => '#1696c9',
        ];

        foreach ($colors as $threshold => $color) {
            if ($totalQuantity <= $threshold) {
                return $color;
            }
        }

        return '#035e82';
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
