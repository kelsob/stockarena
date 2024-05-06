<div class="bg-white rounded-lg shadow-md p-4">
    <h3 class="text-lg font-semibold mb-2">{{ $stock->name }}</h3>
    <p class="text-gray-600 mb-1">{{ $stock->ticker }}</p>
    <p class="text-gray-700 mb-1">${{ $priceHistories->last()->price ?? $stock->price }}</p>
    <p class="text-gray-600 mb-1">{{ $stock->motto }}</p>
    <p class="text-gray-700">{{ $stock->description }}</p>

    <!-- Unique ID for each graph -->
    <canvas id="stockPriceGraph-{{ $stock->id }}" class="stock-chart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <div>
    new Chart(document.getElementById("stockPriceGraph-{{ $stock->id }}"), {
        type: 'line',
        data: {
        labels: JSON.parse('{!! $labelsJson !!}'),
        datasets: [{
            label: 'Price History',
            data: JSON.parse('{!! $dataJson !!}'),
            borderColor: 'rgb(75, 192, 192)',
            borderWidth: 1,
            tension: 0.1,
            fill: {
                target: 'origin',
                above: 'rgb(75, 192, 192)',
                below: 'rgb(75, 192, 192)'
            }
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        },
        elements: {
            point: {
            radius: 0,
            hoverRadius: 6
        }
        }
    }
    });
    </div>
</script>
