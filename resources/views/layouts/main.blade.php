<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

        @livewireStyles
    </head>
    <body>
        <div class="container mx-auto p-4">
            @yield('content')
        </div>

        @livewireScripts
    </body>
</html>
