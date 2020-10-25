@extends('layouts.main')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h1 class="text-4xl text-center font-bold">{{ $package->name }}</h1>

        <p>{{ $package->description }}</p>

        <h2 class="text-xl font-bold">GitHub issues mentioning accessibility</h2>
        <dl>
            <dt>Open</dt>
            <dd>{{ count($package->openGithubIssues) }}</dd>

            <dt>Closed</dt>
            <dd>{{ count($package->closedGithubIssues) }}</dd>
        </dl>

        <h3 class="text-lg font-bold">Open issues</h3>

        @if (count($package->githubIssues) > 0)
            <ul>
                @foreach ($package->openGithubIssues->sortByDesc('daysOld') as $issue)
                    <li>
                        <a href="{{ $issue->url }}">{{ $issue->title }}</a>
                        <span class="text-gray-700 italic">({{ $issue->daysOld }} days old)</span>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="/" class="mt-8 block text-center">Search again</a>
    </div>
@endsection
