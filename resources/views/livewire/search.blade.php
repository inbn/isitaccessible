<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <input type="text" wire:model="searchTerm">

    <ul>
        @foreach($packages as $package)
            <li>
                {{ $package->name }}
            </li>
        @endforeach
    </ul>
</div>
