<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Pengiriman Daily</title>
</head>

<body>
    <table>
        <thead>
            <tr><td colspan="{{ 7 + $categories->count() }}"></td></tr>
            <tr><td colspan="{{ 7 + $categories->count() }}">PT. TUBAN PRIMA ENERGI</td></tr>
            <tr><td colspan="{{ 7 + $categories->count() }}">GENERAL CONTRACTOR DAN SUPPLIER</td></tr>
            <tr><td colspan="{{ 7 + $categories->count() }}">Jl. Sunan Drajat No. 06 Tuban</td></tr>
            <tr><td colspan="{{ 7 + $categories->count() }}"></td></tr>
            <tr><td colspan="{{ 7 + $categories->count() }}"><h1>DAILY REPORT</h1></td></tr>
            <tr><td colspan="{{ 7 + $categories->count() }}"><h1>PENGIRIMAN READYMIX</h1></td></tr>
            <tr><td colspan="{{ 7 + $categories->count() }}"></td></tr>
            <tr><td>Tanggal</td><td colspan="{{ 6 + $categories->count() }}">{{ $tanggal }}</td></tr>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Customer</th>
                <th rowspan="2">No. Pol</th>
                <th rowspan="2">Driver</th>
                <th rowspan="2">No. Order Penjualan</th>
                <th rowspan="2">Jam Pengiriman</th>
                <th rowspan="2">Ket</th>
                <th colspan="{{ $categories->count() }}">Mutu (M3)</th>
            </tr>
            <tr>
                @foreach ($categories as $category)
                    <th>{{ $category->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($pengirimans as $pengiriman)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pengiriman->penjualan->customer->name }}</td>
                    <td>{{ $pengiriman->driver->no_plat }}</td>
                    <td>{{ $pengiriman->driver->name }}</td>
                    <td>{{ $pengiriman->penjualan->no_invoice }}</td>
                    <td>{{ $pengiriman->jam }}</td>
                    <td>{{ $pengiriman->penjualan->project->keterangan }}</td>
                    @foreach ($categories as $category)
                        <td>
                            @if ($pengiriman->penjualan->project->product->category == $category)
                                {{ $pengiriman->penjualan->total_barang }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
