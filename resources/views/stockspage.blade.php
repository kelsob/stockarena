@extends('layouts.app')

@section('content')
    <!-- Your navigation bar here -->
    <div>
        <!-- Display the list of stocks -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($stocks as $stock)
                <livewire:stock-listing :stockId="$stock->id" />
            @endforeach
        </div>
    </div>
@endsection
