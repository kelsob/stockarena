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
    <body>
        {{ $slot }}
    </body>
</html>
