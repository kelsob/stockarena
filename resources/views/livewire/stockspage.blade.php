<div>
    <div class="flex justify-center space-x-2 mb-4">
        <button wire:click="$dispatch('timeScaleChanged', ['1H'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1H</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1D'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1D</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1W'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1W</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1M'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1M</button>
        <button wire:click="$dispatch('timeScaleChanged', ['1Y'])" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">1Y</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($stocks as $stock)
            <livewire:stock-listing :stockId="$stock->id" />
        @endforeach
    </div>
</div>