document.addEventListener("DOMContentLoaded", function () {
    //filter dusun by date
    // Set startDate to the first day of the current month
    var startDate = new Date(
        new Date().getFullYear(),
        new Date().getMonth(),
        1
    );

    // Set endDate to the last day of the current month
    var endDate = new Date(
        new Date().getFullYear(),
        new Date().getMonth() + 1,
        0
    );

    $("#tanggal").daterangepicker({
        format: "YYYY-MM-DD",
        startDate: startDate,
        endDate: endDate,
    });

    $("#tanggal").on("change", function () {
        var dateRange = $(this).val();
        var [start, end] = dateRange.split(" - ");
    });

    const chartElement = document.getElementById("productLocationChart");
    const pieChartElement = document.getElementById("productPieChart");
    let chart, pieChart;

    function initChart(data) {
        chart = Highcharts.chart(chartElement, {
            chart: {
                type: "column",
            },
            title: {
                text: "Product Quantities by Location",
            },
            xAxis: {
                type: "category",
                title: {
                    text: "Products",
                },
            },
            yAxis: {
                title: {
                    text: "Quantity",
                },
            },
            series: [
                {
                    name: "Quantity",
                    data: data,
                },
            ],
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        format: "{y}",
                    },
                },
            },
            tooltip: {
                headerFormat:
                    '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat:
                    '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br />',
            },
        });
    }

    function initPieChart(data) {
        pieChart = Highcharts.chart(pieChartElement, {
            chart: {
                type: "pie",
            },
            title: {
                text: "Product Distribution",
            },
            series: [
                {
                    name: "Quantity",
                    data: data,
                },
            ],
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: "pointer",
                    dataLabels: {
                        enabled: true,
                        format: "<b>{point.name}</b>: {point.y} ({point.percentage:.2f}%)",
                    },
                },
            },
            tooltip: {
                pointFormat: "<b>{point.y}</b>",
            },
        });
    }

    function updateChart(data) {
        if (chart) {
            chart.series[0].setData(data);
        } else {
            initChart(data);
        }
    }

    function updatePieChart(data) {
        if (pieChart) {
            pieChart.series[0].setData(data);
        } else {
            initPieChart(data);
        }
    }

    function updateTable(data) {
        console.log(data);
        const tableBody = document.querySelector("#example0 tbody");
        tableBody.innerHTML = "";

        let no = 1;
        data.forEach((location) => {
            Object.entries(location.data).forEach(([product, quantity]) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                            <td>${no++}</td>
                            <td>${product}</td>
                            <td>${quantity}</td>
                            `;
                tableBody.appendChild(row);
            });
        });
    }

    function updateProductLeaderboard(leaderboard, products) {
        const productLeaderboardTable = document.querySelector("#example3 tbody");
        productLeaderboardTable.innerHTML = "";

        leaderboard.forEach((location, index) => {
            const row = document.createElement("tr");

            row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${location.name}</td>
                        ${products
                            .map(
                                (product) =>
                                    `<td>${
                                        location["product_" + product.id] ?? 0
                                    }</td>`
                            )
                            .join("")}
                        <td>${location.total_sales}</td>
                    `;
            productLeaderboardTable.appendChild(row);
        });
    }

    function updateLeaderboard(leaderboard, products) {
        const leaderboardTable = document.querySelector("#examplesales tbody");
        leaderboardTable.innerHTML = "";

        leaderboard.forEach((location, index) => {
            const row = document.createElement("tr");

            row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${location.name}</td>
                        ${products
                            .map(
                                (product) =>
                                    `<td>${
                                        location["product_" + product.id] ?? 0
                                    }</td>`
                            )
                            .join("")}
                        <td>${location.total_sales}</td>
                    `;
            leaderboardTable.appendChild(row);
        });
    }

    function fetchChartData() {
        const formData = new FormData(document.getElementById("filterForm"));
        const queryString = new URLSearchParams(formData).toString();

        // Fetch chart data
        fetch(`/chart-data?${queryString}`)
            .then((response) => response.json())
            .then((data) => {
                const chartData = data.flatMap((location) =>
                    Object.entries(location.data).map(
                        ([product, quantity]) => ({
                            name: product,
                            y: quantity,
                            color: location.colors[product]
                        })
                    )
                );
                updateChart(chartData);
                updatePieChart(chartData);
                updateTable(data);
            });

        // Fetch leaderboard data
        fetch(`/product-leaderboard?${queryString}`)
            .then((response) => response.json())
            .then((data) => {
                updateProductLeaderboard(
                    data.productLeaderboard,
                    data.products
                );
            });
        fetch(`/leaderboard?${queryString}`)
            .then((response) => response.json())
            .then((data) => {
                updateLeaderboard(data.leaderboard, data.products);
            });
    }

    fetchChartData();
});
