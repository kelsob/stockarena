@extends('layouts.app')

@section('content')
    <div>
        <div class="flex justify-center space-x-4 mb-4">
            <button wire:click="$emit('updateCharts', '1Hour')" class="px-4 py-2 bg-blue-500 text-white rounded">1 Hour</button>
            <button wire:click="$emit('updateCharts', '1Day')" class="px-4 py-2 bg-blue-500 text-white rounded">1 Day</button>
            <button wire:click="$emit('updateCharts', '1Week')" class="px-4 py-2 bg-blue-500 text-white rounded">1 Week</button>
            <button wire:click="$emit('updateCharts', '1Month')" class="px-4 py-2 bg-blue-500 text-white rounded">1 Month</button>
            <button wire:click="$emit('updateCharts', '1Year')" class="px-4 py-2 bg-blue-500 text-white rounded">1 Year</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($stocks as $stock)
                <livewire:stock-listing :stockId="$stock->id" />
            @endforeach
        </div>
    </div>
@endsection


