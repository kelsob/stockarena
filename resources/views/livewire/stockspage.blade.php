<div class="mx-auto max-w-screen-xl">
    <div class="flex justify-center space-x-2 mb-4">
        <button wire:click="$dispatch('timeScaleChanged', ['1H'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1H</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1D'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1D</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1W'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1W</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1M'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1M</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1Y'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1Y</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($stocks as $stock)
            <livewire:stock-listing :stockId="$stock->id" :key="'stock-listing-' . $stock->id"/>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $stocks->links() }}
    </div> 
</div>

<script>
    document.addEventListener('livewire:load', function () {
        initializeGraphs();  // Initial call to function when the page loads

        Livewire.hook('message.processed', (message, component) => {
            if (component.fingerprint.name === 'stockspage') {
                initializeGraphs();  // Re-initialize graphs after every Livewire update
            }
        });
    });

    function initializeGraphs() {
        document.querySelectorAll('.stock-chart').forEach(function(canvas) {
            // Assume you're using Chart.js or similar
            const ctx = canvas.getContext('2d');
            // Check if chart instance already exists
            if (!canvas.chart) {
                canvas.chart = new Chart(ctx, {
                    type: 'line',  // Example type
                    data: { ... }, // Data needs to be dynamically fetched or passed via Livewire
                    options: { ... }  // Chart options
                });
            } else {
                // Update the existing chart data if necessary
                canvas.chart.update();
            }
        });
    }
</script>