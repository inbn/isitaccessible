<div>
    <label for="query">Search for a package</label>
    <input
        id="query"
        type="text"
        wire:model="query"
        wire:keydown.escape="resetForm"
        wire:keydown.tab="resetForm"
        wire:keydown.ArrowUp="decrementHighlight"
        wire:keydown.ArrowDown="incrementHighlight"
        wire:keydown.enter="selectPackage"
    >

    <div wire:loading class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
        <div class="list-item">Searching...</div>
    </div>

    @if(!empty($query))
        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetForm"></div>

        <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
            @if(!empty($packages))
                @foreach($packages as $i => $package)
                    <a
                        href="{{ route('show-package', $package['name']) }}"
                        class="list-item {{ $highlightIndex === $i ? 'highlight' : '' }}"
                    >{{ $package['name'] }}</a>
                @endforeach
            @else
                <div class="list-item">No results!</div>
            @endif
        </div>
    @endif
</div>
