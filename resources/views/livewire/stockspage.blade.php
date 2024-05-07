
<div>
    @section('content')
    <div class="flex justify-center space-x-4 mb-4">
        <button wire:click="testFunction">1 Hour</button>
        <button wire:click="testFunction">1 Day</button>
        <button wire:click="testFunction">1 Week</button>
        <button wire:click="testFunction">1 Month</button>
        <button wire:click="testFunction">1 Year</button>

    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($stocks as $stock)
            <livewire:stock-listing :stockId="$stock->id" />
        @endforeach
    </div>
    @endsection
</div>