<div>
    <div class="flex items-start justify-center pl-2 space-x-2 w-128 H-128"> <!-- Add padding to all sides or specifically to the left (pl-4) -->
        <a href="{{ route('stockspage') }}" class="inline-block p-2 bg-gray-200 text-gray-800 hover:bg-gray-300 rounded ml 10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div class="bg-white rounded-lg shadow-md p-2 max-w-screen-xl w-full"> <!-- max-w-screen-xl and w-full to fill the rest of the space -->
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
            
            <div class="flex flex-col md:flex-row justify-center items-start space-x-4 max-w-screen-xl mx-auto">
                <div class="flex items-start justify-center space-x-2 w-full md:w-3/5">
                    <canvas id="stockPriceGraph" class="stock-chart"></canvas>
                </div>
                <div class="w-full md:w-2/5 bg-white rounded-lg shadow p-4">
                    <div class="mb-4">
                        <h2 class="text-lg font-bold mb-2">Stock Details</h2>
<!--                        <p><strong>Player's Stake:</strong> </p> 
                        <p><strong>Current Market Value:</strong> </p>
                        <p><strong>Shares Available:</strong> </p> -->
                    </div>
                    <div class="mb-4">
                        <h2 class="text-lg font-bold mb-2">Transactions</h2>
                        <form class="mb-2">
                            <label for="buyQuantity" class="block text-sm font-medium text-gray-700">Buy Quantity</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" name="buyQuantity" id="buyQuantity" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-2 sm:text-sm border-gray-300 rounded-md" placeholder="0">
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md">Buy</button>
                            </div>
                        </form>
                        <form>
                            <label for="sellQuantity" class="block text-sm font-medium text-gray-700">Sell Quantity</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" name="sellQuantity" id="sellQuantity" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-2 sm:text-sm border-gray-300 rounded-md" placeholder="0">
                                <button type="submit" class="ml-2 px-4 py-2 bg-red-500 hover:bg-red-700 text-white font-bold rounded-md">Sell</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="justify-center">
    <div class="mx-auto max-w-screen-xl">
        <div class="flex item-start space-x-4 mb-2 mt-2">
            <!-- Time Scale Buttons Left-aligned -->
            <div class="flex space-x-2 pl-8">
                <button wire:click="$dispatch('timeScaleChanged', ['1H'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1H</button>
                <button wire:click="$dispatch('timeScaleChanged', ['1D'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1D</button>
                <button wire:click="$dispatch('timeScaleChanged', ['1W'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1W</button>
                <button wire:click="$dispatch('timeScaleChanged', ['1M'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1M</button>
                <button wire:click="$dispatch('timeScaleChanged', ['1Y'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1Y</button>
            </div>

            <!-- Chart Type Buttons Right-aligned -->
            <div class="flex space-x-2">
                <button wire:click="$dispatch('chartTypeChanged', ['line'])" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded transition duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" class="w-6 h-6">
                        <path d="M2 17 L6 10 L12 14 L18 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button wire:click="$dispatch('chartTypeChanged', ['bar'])" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded transition duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                        <rect x="1" y="14" width="6" height="4" />
                        <rect x="8" y="10" width="6" height="8" />
                        <rect x="15" y="2" width="6" height="16" />
                    </svg>
                </button>
                <button wire:click="$dispatch('chartTypeChanged', ['pie'])" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded transition duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none" stroke="currentColor" class="w-6 h-6">
                        <!-- Outer circle to create a hollow effect -->
                        <circle cx="16" cy="16" r="15" fill-opacity="0.5" stroke-width="2"/>

                        <!-- First pie segment -->
                        <path d="M16 16 L16 5 A15 15 0 0 1 27 16 Z" fill="currentColor"/>

                    </svg>
                </button>
            </div>
        </div>
    </div>
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

