@extends('layouts.master')

@section('title', 'Pemetaan')

@section('container')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            width: 100%;
            height: 90vh;
        }
    </style>
    <div id="map"></div>
@endsection
@section('page-script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-7.656172633765166, 111.32830621325536], 9.11);

        // Add a base map layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://decaa.idt">DECAA.ID</a> X OSM contributors'
        }).addTo(map);

        // Maps data from the backend
        const maps = @json($data);
        console.log("Maps Data:", maps);

        // Iterate through maps and create polygons
        maps.forEach(peta => {
            console.log("Popup Data for:", peta.name, peta.data); // Debugging

            const polygon = L.polygon(peta.coordinates.map(coord => [coord[1], coord[0]]), {
                color: peta.color,
            }).addTo(map);

            // Bind popup with location name and product percentages
            polygon.bindPopup(`
            <b>${peta.name || 'Unknown'}</b><br>
            ${peta.data && Object.keys(peta.data).length
                ? Object.entries(peta.data)
                    .map(([product, percentage]) => `${product}: ${percentage}`)
                    .join('<br>')
                : 'No product data available'}
            <br>
            <a href="${peta.nextRoute}">View Detail</a>
        `);
        });
    </script>
@endsection
