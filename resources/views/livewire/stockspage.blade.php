<div class="mx-auto max-w-screen-xl">
    <div class="flex justify-center space-x-2 mb-2 mt-2">
        <button wire:click="$dispatch('timeScaleChanged', ['1H'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1H</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1D'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1D</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1W'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1W</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1M'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1M</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1Y'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">1Y</button>
    </div>

    <!-- Chart Type Buttons -->
    <div class="flex justify-center space-x-2 mb-2">
        <button wire:click="$dispatch('chartTypeChanged', ['line'])" class="bg-green-500 hover:bg-green-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">Line</button>
        <button wire:click="$dispatch('chartTypeChanged', ['bar'])" class="bg-green-500 hover:bg-green-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">Bar</button>
        <button wire:click="$dispatch('chartTypeChanged', ['pie'])" class="bg-green-500 hover:bg-green-700 text-white font-bold py-0 px-2 rounded transition duration-300 ease-in-out">Pie</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($stocks as $stock)
            <livewire:stock-listing :stock="$stock" :timeScale="$timeScale" :chartType="$chartType" :key="'stock-listing-' . $stock->id"/>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $stocks->links() }}
    </div> 
</div>