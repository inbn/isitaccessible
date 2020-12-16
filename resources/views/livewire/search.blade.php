<div>
    <div class="site-search mt-6">
        @if (!empty($query) && !empty($packages))
            <p
                class="search-results-count sr-only"
                id="search-results-count"
                aria-live="polite"
                aria-atomic="true"
            >
                Found {{ count($packages) }} results for “{{ $query }}”
            </p>
        @endif
        <label for="search-input" class="block text-center">Enter the name of a package. Use the arrow keys or your mouse to select a package or press enter to search.</label>
        <div
            role="combobox"
            aria-expanded="{{ !empty($packages) && !empty($query) ? 'true' : 'false' }}"
            aria-owns="search-results-listbox"
            aria-haspopup="listbox"
        >
            <input
                id="query"
                type="text"
                id="search-input"
                class="site-search__input"
                autoComplete="off"
                aria-autocomplete="list"
                aria-controls="search-results-listbox"
                aria-activedescendant="{{ (!empty($packages) && !empty($query)) ? 'result-item-' . $highlightIndex : '' }}"
                wire:model="query"
                wire:keydown.escape="resetForm"
                wire:keydown.tab="resetForm"
                wire:keydown.arrow-up="decrementHighlight"
                wire:keydown.arrow-down="incrementHighlight"
                wire:keydown.enter="selectPackage"
            >
        </div>

        @if(!empty($query))
            <ol
                id="search-results-listbox"
                class="site-search__results-list"
                role="listbox"
                {{ (empty($packages) || empty($query)) ? 'hidden' : '' }}
            >
                @if(!empty($packages))
                    @foreach($packages as $i => $package)
                        <li
                            id="result-item-{{ $i }}"
                            role="option"
                            class="site-search__result"
                            aria-selected="{{ $highlightIndex === $i ? 'true' : 'false' }}"
                            wire:key="{{ $package['id'] }}"
                            wire:click="selectPackage({{ $i }})"
                        >
                            <p class="font-bold">{{ $package['name'] }}</p>
                            @if($package['description'])
                                <p class="mt-0 text-sm text-gray-800">{{ $package['description'] }}</p>
                            @endif
                        </li>
                    @endforeach
                @else
                    <li class="site-search__result hover:bg-white">No results. Press enter to search.</li>
                @endif
            </ol>
        @endif
    </div>

    @svg('search-by-algolia-light-background', ['class' => 'block mx-auto mt-4'])
</div>

