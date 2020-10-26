@extends('layouts.main')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h1 class="text-4xl text-center font-bold">isitaccessible.dev</h1>

        <p class="text-center italic text-gray-800 text-xl">Check if that npm package you’re about to install has accessibility issues</p>

        @livewire('search')
    </div>
@endsection
