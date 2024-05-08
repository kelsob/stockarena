<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        <link href="{{ mix('resources/css/app.css') }}" rel="stylesheet"> <!-- Ensure path is correct -->
        <script type="module" src="{{ mix('resources/js/app.js') }}" defer></script> <!-- Ensure path is correct and 'defer' to delay script execution -->
    
        @livewireStyles
    </head>
    <body class="bg-gray-100">
        <header class="bg-blue-500 text-white mb-4">
            <div class="container mx-auto flex justify-between items-center p-6">
                <h1 class="text-lg font-bold">{{ config('app.name', 'Your Website') }}</h1>
                <nav>
                    <a href="/" class="text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Home</a>
                    <a href="/about" class="text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Market</a>
                    <a href="/services" class="text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Portfolio</a>
                </nav>
            </div>
        </header>
        <div>
            {{ $slot }}
        </div>
    </body>
</html>
