<div class="bg-white rounded-lg shadow-md p-4">
    <h3 class="text-lg font-semibold mb-2">{{ $stock->name }}</h3>
    <p class="text-gray-600 mb-1">{{ $stock->ticker }}</p>
    <p class="text-gray-700 mb-1">${{ $priceHistories->last()->price ?? $stock->price }}</p>
    <p class="text-gray-600 mb-1">{{ $stock->motto }}</p>
    <p class="text-gray-700">{{ $stock->description }}</p>

    <!-- Placeholder for the graph -->
    <div wire:ignore id="stockPriceGraph" style="height: 300px;"></div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
    var data = @json($priceHistories->pluck('price', 'created_at'));
    console.log(data); // Check what's output here

    var chart = new Chart(document.getElementById('stockPriceGraph').getContext('2d'), {
        type: 'line',
        data: {
            labels: Object.keys(data),
            datasets: [{
                label: 'Price History',
                data: Object.values(data),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
});
</script>
@endpush
