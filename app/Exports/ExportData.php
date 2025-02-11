<?php

namespace App\Exports;

use App\Models\Location;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportData implements FromView, WithEvents
{
    protected $startDate;

    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        // Query data with filters
        $products = Product::with(['locations' => function ($query) {
            $query->wherePivot('date', '>=', $this->startDate)
                ->wherePivot('date', '<=', $this->endDate);
        }])->get();

        // Group and structure the data hierarchically
        $groupedData = $this->structureData($products);

        // dd([
        //     'groupedData' => $groupedData,
        //     'startDate' => $this->startDate,
        //     'endDate' => $this->endDate,
        // ]);
        return view('exports.product_report', [
            'groupedData' => $groupedData,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }

    private function structureData($products)
    {
        $result = [];
        foreach ($products as $product) {
            foreach ($product->locations as $location) {
                $kecamatanId = $location->pivot->location_kecamatan_id;
                $desaId = $location->pivot->location_desa_id;
                $dusunId = $location->pivot->location_dusun_id;
                $salesUserId = $location->pivot->user_id;

                $kecamatan = Location::find($kecamatanId);
                $desa = Location::find($desaId);
                $dusun = Location::find($dusunId);
                $salesName = \App\Models\User::find($salesUserId)?->name ?? 'Unknown Sales';

                $result[$salesName][$kecamatan->name][$desa->name][$dusun->name][$product->name] =
                    ($result[$salesName][$kecamatan->name][$desa->name][$dusun->name][$product->name] ?? 0) +
                    $location->pivot->quantity;
            }
        }

        return $result;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('A1:E1')->getFont()->setBold(true);
            },
        ];
    }
}
