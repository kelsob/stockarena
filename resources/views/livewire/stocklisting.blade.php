<a href="{{ route('Stockdetails', $stock->id) }}" class="block text-decoration-none">
    <div class="bg-white rounded-lg shadow-md p-4 hover:bg-gray-100">
        <div class="flex justify-between items-center mb-0">
            <h3 class="text-lg font-semibold">{{ $stock->ticker }}</h3>
            <p class="text-lg font-bold">${{ number_format($priceHistories->last()->price ?? $stock->price, 2) }}</p>
        </div>
        <div class="flex justify-between items-center mb-0">
            <p class="text-gray-600 mb-1">{{ $stock->name }}</p>
            <p class="mb-1 {{ $priceDifference >= 0 ? 'text-green-500' : 'text-red-500' }} font-semibold">
                {{ $priceDifference >= 0 ? '+$' : '-$' }}{{ number_format(abs($priceDifference), 2) }} ({{ $priceDifference >= 0 ? '+' : '-' }}{{ number_format(abs($percentageDifference), 2) }}%)
            </p>
        </div>
        <p class="text-gray-600 mb-1">{{ $stock->motto }}</p>
        <p class="text-gray-700">{{ $stock->description }}</p>
        <canvas id="stockPriceGraph-{{ $stock->id }}" class="stock-chart"></canvas>
    </div>
</a>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById("stockPriceGraph-{{ $stock->id }}"), {
        type: '{{ $chartType }}',
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
                above: 'rgb(152, 237, 237)',
                below: 'rgb(152, 237, 237)'
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
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
