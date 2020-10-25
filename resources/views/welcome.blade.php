<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @livewireStyles
    </head>
    <body>
        <h1>isitaccessible.dev</h1>
        <p>See if that package you’re about to install has accessibility issues</p>
        @livewire('search')

        @livewireScripts
    </body>
</html>
