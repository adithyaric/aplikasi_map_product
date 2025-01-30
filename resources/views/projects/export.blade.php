<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Project</title>
</head>

<body>
    <table border="1">
        <thead>
            <tr><td colspan="7"></td></tr>
            <tr><td colspan="7">MAPPING PRODUCT</td></tr>
            <tr><td colspan="7">GENERAL CONTRACTOR DAN SUPPLIER</td></tr>
            <tr><td colspan="7">Jl. Sunan Drajat No. 06 Tuban</td></tr>
            <tr><td colspan="7"></td></tr>
            <tr><td colspan="7"><h1>PROJECT REPORT</h1></td></tr>
            <tr><td colspan="7"></td></tr>
            <tr><td>Tanggal</td><td colspan="6">{{ $startDate }} - {{ $endDate }}</td></tr>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>TGL</th>
                <th>Produk Diminta</th>
                <th>Produk Dibuat</th>
                <th>Harga Project</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->customer->name }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>{{ $project->jml_product }}</td>
                    <td>{{ $project->entries->sum('capaian') }}</td>
                    <td>{{ $project->harga }}</td>
                    <td>{{ $project->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
