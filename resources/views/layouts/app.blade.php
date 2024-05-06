<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ mix('resources/css/app.css') }}" rel="stylesheet"> <!-- Ensure path is correct -->
    <!-- Scripts -->
    <script src="{{ mix('resources/js/app.js') }}" defer></script> <!-- Ensure path is correct and 'defer' to delay script execution -->
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-gray-800">
            <div class="container mx-auto px-4 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex-shrink-0">
                        <a href="{{ route('/') }}" class="text-white text-lg font-semibold">Stock Simulator</a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center space-x-4">
                            <a href="{{ route('stockspage') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Stocks</a>
                            <a href="{{ route('portfoliopage') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Portfolio</a>
                            <a href="{{ route('communitypage') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Community</a>
                        </div>
                    </div>
                </div>
            </nav>
        <!-- Page content -->
        <div class="py-6">
            <div class="container mx-auto px-4">
                @yield('content')
            </div>
        </div>
        <!-- Place scripts at the bottom to ensure HTML content loads first -->
        @stack('scripts')
    </div>

</body>
</html>
