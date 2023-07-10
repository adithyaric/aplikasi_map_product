<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Stock In Out</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th rowspan="2">TGL</th>
                <th rowspan="2">PROD KE</th>
                <th rowspan="2">RIT</th>
                <th rowspan="2">No. Order Penjualan</th>
                <th rowspan="2">Jam Pengiriman</th>
                <th colspan="{{ $categories->count() }}">Mutu (M3)</th>
                @foreach ($bahanbakus as $bahanbaku)
                    <th colspan="3">{{ $bahanbaku->name }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($categories as $category)
                    <th>{{ $category->name }}</th>
                @endforeach
                @foreach ($bahanbakus as $bahanbaku)
                    <th>Stock</th>
                    <th>In</th>
                    <th>Out</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $currentDate = null;
                $counter = 1;
            @endphp
            @foreach ($pengirimans as $pengiriman)
                <tr>
                    @if ($pengiriman->tgl_pengiriman != $currentDate)
                        <td>{{ $pengiriman->tgl_pengiriman }}</td>
                        @php
                            $currentDate = $pengiriman->tgl_pengiriman;
                            $counter = 1;
                        @endphp
                    @else
                        <td></td>
                    @endif
                    <td>{{ $counter++ }}</td>
                    <td>{{ $pengiriman->rit }}</td>
                    <td>{{ $pengiriman->penjualan->no_invoice }}</td>
                    <td>{{ $pengiriman->jam }}</td>
                    @foreach ($categories as $category)
                        <td>
                            @if ($pengiriman->penjualan->project->product->category == $category)
                                {{ $pengiriman->penjualan->total_barang }}
                            @endif
                        </td>
                    @endforeach
                    @foreach ($bahanbakus as $bahanbaku)
                        <td>
                            {{-- {{ $bahanbaku->stock - $bahanbaku->product()->withPivot('total')->get()->sum('pivot.total') }} --}}
                            {{ $bahanbaku->stock - $pengiriman->penjualan->project->product->bahanbaku()->withPivot('total')->get()->sum('pivot.total') }}
                        </td>
                        <td>
                            {{-- {{ $bahanbaku->pembelian->sum('jumlah') }} --}}
                            @php
                                $pengirimanBahanBakus = $pengiriman->penjualan->project->product->bahanbaku;
                                if ($pengirimanBahanBakus->contains($bahanbaku)) {
                                    echo $bahanbaku
                                        ->pembelian()
                                        ->where('tgl_dibuat', $pengiriman->tgl_pengiriman)
                                        ->sum('jumlah');
                                } else {
                                    echo $bahanbaku->pembelian->where('tgl_dibuat', $pengiriman->tgl_pengiriman)->sum('jumlah');
                                }
                            @endphp
                        </td>
                        <td>
                            {{-- {{ $bahanbaku->product()->withPivot('total')->get()->sum('pivot.total') }} --}}
                            {{ $pengiriman->penjualan->project->product->bahanbaku()->withPivot('total')->get()->sum('pivot.total') }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
{{-- {{ die() }} --}}
