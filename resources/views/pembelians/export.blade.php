<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Pembelian</title>
</head>

<body>
    <table>
        <thead>
            <tr><td colspan="8"></td></tr>
            <tr><td colspan="8">PT. TUBAN PRIMA ENERGI</td></tr>
            <tr><td colspan="8">GENERAL CONTRACTOR DAN SUPPLIER</td></tr>
            <tr><td colspan="8">Jl. Sunan Drajat No. 06 Tuban</td></tr>
            <tr><td colspan="8"></td></tr>
            <tr><td colspan="8"><h1>LAPORAN PEMBELIAN</h1></td></tr>
            <tr><td colspan="8"></td></tr>
            <tr><td>Tanggal</td><td colspan="7">{{ $startDate }} - {{ $endDate }}</td></tr>
            <tr>
                <th>No</th>
                <th>TGL</th>
                <th>Nama Bahan Baku</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelians as $pembelian)
                <tr>
                    <td>{{ $pembelian->id }}</td>
                    <td>{{ $pembelian->tgl_dibuat }}</td>
                    <td>{{ $pembelian->bahanbaku->name }}</td>
                    <td>{{ $pembelian->jumlah }}</td>
                    <td>{{ $pembelian->bahanbaku->satuan->name }}</td>
                    <td>{{ $pembelian->harga }}</td>
                    <td>{{ $pembelian->harga * $pembelian->jumlah }}</td>
                    <td>{{ $pembelian->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
