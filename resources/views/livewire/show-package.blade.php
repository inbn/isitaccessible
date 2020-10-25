<div>
    <h1>{{ $package->name }}</h1>

    <p>{{ $package->description }}</p>

    <dl>
        <dt>Open GitHub issues</dt>
        <dd>{{ count($package->openGithubIssues) }}</dd>

        <dt>Closed GitHub issues</dt>
        <dd>{{ count($package->closedGithubIssues) }}</dd>
    </dl>

    @if (count($package->githubIssues) > 0)
        <ul>
            @foreach ($package->openGithubIssues->sortByDesc('daysOld') as $issue)
                <li>
                    <a href="{{ $issue->url }}">{{ $issue->title }}</a>
                    {{ $issue->daysOld }} days old
                </li>
            @endforeach
        </ul>
    @endif
</div>
