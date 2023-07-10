<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Pengiriman</title>
</head>

<body>
    <table>
        <thead>
            <tr><td colspan="8"></td></tr>
            <tr><td colspan="8">PT. TUBAN PRIMA ENERGI</td></tr>
            <tr><td colspan="8">GENERAL CONTRACTOR DAN SUPPLIER</td></tr>
            <tr><td colspan="8">Jl. Sunan Drajat No. 06 Tuban</td></tr>
            <tr><td colspan="8"></td></tr>
            <tr><td colspan="8"><h1>RITASE REPORT</h1></td></tr>
            <tr><td colspan="8"></td></tr>
            <tr><td>Tanggal</td><td colspan="7">{{ $startDate }} - {{ $endDate }}</td></tr>
            <tr>
                <th>No</th>
                <th>TGL</th>
                <th>No. POL</th>
                <th>Driver</th>
                <th>No. Order Penjualan</th>
                <th>Jarak Tempuh (KM)</th>
                <th>Total Solar Digunakan (L)</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengirimans as $pengiriman)
                <tr>
                    <td>{{ $pengiriman->id }}</td>
                    <td>{{ $pengiriman->tgl_pengiriman }}</td>
                    <td>{{ $pengiriman->driver->no_plat }}</td>
                    <td>{{ $pengiriman->driver->name }}</td>
                    <td>{{ $pengiriman->penjualan->no_invoice }}</td>
                    <td>{{ $pengiriman->jarak }}</td>
                    <td>{{ $pengiriman->solar }}</td>
                    <td>{{ $pengiriman->penjualan->project->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
