@extends('layouts.main')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h1 class="text-4xl text-center font-bold">{{ $package->name }}</h1>

        <p>{{ $package->description }}</p>

        <h2 class="text-2xl font-bold">GitHub issues mentioning accessibility</h2>
        <dl class="flex justify-around">
            <div class="flex flex-col text-center">
                <dt>Open</dt>
                <dd class="text-3xl font-bold">{{ count($package->openGithubIssues) }}</dd>
            </div>

            <div class="flex flex-col text-center">
                <dt>Closed</dt>
                <dd class="text-3xl font-bold">{{ count($package->closedGithubIssues) }}</dd>
            </div>
        </dl>

        @if (count($package->openGithubIssues) > 0)
            <h3 class="text-lg font-bold">Open issues</h3>
            <ul>
                @foreach ($package->openGithubIssues->sortByDesc('daysOld') as $issue)
                    <li>
                        <a href="{{ $issue->url }}">{{ $issue->title }}</a>
                        <span class="text-gray-700 italic">({{ $issue->daysOld }} days old)</span>
                    </li>
                @endforeach
            </ul>
        @endif

        <h2 class="text-2xl font-bold">axe score</h2>

        <p class="text-gray-700 italic">Coming soon</p>

        <a href="/" class="mt-8 block text-center">Search for another package</a>
    </div>
@endsection
