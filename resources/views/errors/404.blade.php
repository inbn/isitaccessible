@extends('layouts.main')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h1 class="text-4xl text-center font-bold">404</h1>

        <p class="text-center italic text-gray-800 text-xl">{{ $exception->getMessage() }}. Please search again.</p>

        @livewire('search')
    </div>
@endsection
