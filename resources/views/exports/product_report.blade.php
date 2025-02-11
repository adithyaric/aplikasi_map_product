<table>
    <tr>
        <th colspan="5">REPORT PENYEBARAN PRODUCT PERIODE
            {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F
                                                Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</th>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    <!-- Dynamic Sales Name -->
    @foreach ($groupedData as $salesName => $salesData)
        <tr>
            <td colspan="5">SALES {{ strtoupper($salesName) }}</td>
        </tr>

        <tr>
            <th>KECAMATAN</th>
            <th>DESA</th>
            <th>DUSUN</th>

            <!-- Extract product names dynamically -->
            @php
                $firstKecamatan = array_key_first($salesData);
                $firstDesa = array_key_first($salesData[$firstKecamatan]);
                $firstDusun = array_key_first($salesData[$firstKecamatan][$firstDesa]);
                $productNames = array_keys($salesData[$firstKecamatan][$firstDesa][$firstDusun]);
            @endphp

            @foreach ($productNames as $productName)
                <th>{{ strtoupper($productName) }}</th>
            @endforeach
        </tr>

        @php $grandTotals = []; @endphp

        <!-- Loop through the hierarchical data -->
        @foreach ($salesData as $kecamatan => $desas)
            @foreach ($desas as $desa => $dusuns)
                @foreach ($dusuns as $dusun => $products)
                    <tr>
                        <td>{{ $kecamatan }}</td>
                        <td>{{ $desa }}</td>
                        <td>{{ $dusun }}</td>
                        @foreach ($productNames as $productName)
                            <td>{{ $products[$productName] ?? 0 }}</td>
                            @php $grandTotals[$productName] = ($grandTotals[$productName] ?? 0) + ($products[$productName] ?? 0); @endphp
                        @endforeach
                    </tr>
                @endforeach

                <!-- Desa Totals -->
                <tr>
                    <td></td>
                    <td>{{ $desa }} TOTAL</td>
                    <td></td>
                    @foreach ($productNames as $productName)
                        @php
                            $desaTotal = collect($dusuns)->sum(function ($d) use ($productName) {
                                return $d[$productName] ?? 0;
                            });
                        @endphp
                        <td>{{ $desaTotal }}</td>
                    @endforeach
                </tr>
            @endforeach
        @endforeach

        <!-- Grand Total -->
        <tr>
            <td colspan="3">TOTAL KESELURUHAN</td>
            @foreach ($grandTotals as $total)
                <td>{{ $total }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
