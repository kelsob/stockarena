<div class="flex items-start pl-4 space-x-4"> <!-- Add padding to all sides or specifically to the left (pl-4) -->
    <a href="{{ route('stockspage') }}" class="inline-block p-2 bg-gray-200 text-gray-800 hover:bg-gray-300 rounded ml 10">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </a>
    <div class="bg-white rounded-lg shadow-md p-4 max-w-screen-xl w-full"> <!-- max-w-screen-xl and w-full to fill the rest of the space -->
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
        
        <canvas id="stockPriceGraph" class="stock-chart"></canvas>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById("stockPriceGraph"), {
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

