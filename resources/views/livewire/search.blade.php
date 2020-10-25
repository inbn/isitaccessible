<div>
    <label for="searchTerm">Search for a package</label>
    <input id="searchTerm" type="text" wire:model="searchTerm">
    <ul>
        @foreach($packages as $package)
            <li>
                {{ $package->name }}
            </li>
        @endforeach
    </ul>
</div>
