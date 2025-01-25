<!DOCTYPE html>
<html>

<head>
    <title>GIS - Regions</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            width: 100%;
            height: 98vh;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-7.431, 111.886], 9.11);

        // Add a base map layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // maps data from the backend
        const maps = @json($data);
        console.log(maps);

        // Iterate through maps and create polygons
        maps.forEach(peta => {
            const polygon = L.polygon(peta.coordinates.map(coord => [coord[1], coord[0]]), {
                color: peta.color,
            }).addTo(map);

            // Add a popup with peta name and product percentages
            polygon.bindPopup(() => {
                const products = Object.entries(peta.data)
                    .map(([product, percentage]) => `${product}: ${percentage}%`)
                    .join('<br>');

                return `
                    <b>${peta.name}</b><br>
                    ${products}<br>
                    <a target="_blank" href="${peta.nextRoute}">View Detail</a>
                `;
            });
        });
    </script>
</body>

</html>
