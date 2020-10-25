@extends('layouts.main')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h1 class="text-4xl text-center font-bold">isitaccessible.dev</h1>

        <p class="text-center">Check if that npm package you’re about to install has accessibility issues</p>

        @livewire('search')
    </div>
@endsection
