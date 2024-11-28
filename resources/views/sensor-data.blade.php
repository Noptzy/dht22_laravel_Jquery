<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor DHT22 Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Sensor Data Monitoring</h1>
{{-- 
        <!-- Tabel Data -->
        <div class="mt-4">
            <h2>Data Terkini</h2>
            <table class="table table-bordered">
                {{-- <thead>
                    <tr>
                        <th>No</th>
                        <th>Temperature (°C)</th>
                        <th>Humidity (%)</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sensorData as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->temperature }}</td>
                            <td>{{ $data->humidity }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->toDateTimeString() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        </div> --}}

        <!-- Grafik Data -->
        <div class="mt-5">
            <h2>Grafik Perkembangan</h2>
            <canvas id="sensorChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const labels = @json($sensorData->pluck('created_at')->map(fn($time) => \Carbon\Carbon::parse($time)->toDateTimeString()));
            const temperatures = @json($sensorData->pluck('temperature'));
            const humidities = @json($sensorData->pluck('humidity'));

            const ctx = document.getElementById('sensorChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Temperature (°C)',
                            data: temperatures,
                            borderColor: 'red',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                        },
                        {
                            label: 'Humidity (%)',
                            data: humidities,
                            borderColor: 'blue',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Value'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
