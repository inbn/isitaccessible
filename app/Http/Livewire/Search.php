<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;

class Search extends Component
{
    public $query;
    public $packages;
    public $highlightIndex;

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->query = '';
        $this->packages = [];
        $this->highlightIndex = -1; // No item highlighted
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->packages) - 1) {
            $this->highlightIndex = -1;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === -1) {
            $this->highlightIndex = count($this->packages) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectPackage($packageIndex = null)
    {
        if ($packageIndex)
        {
            $package = $this->packages[$packageIndex];
        }
        else
        {
            $package = $this->packages[$this->highlightIndex] ?? null;
        }

        if ($package)
        {
            $this->redirect(route('show-package', $package['name']));
        }
        else if (!empty($this->query))
        {
            $this->redirect(route('show-package', $this->query));
        }
    }

    public function updatedQuery()
    {
        $this->packages = Package::search($this->query)
            ->take(12)
            ->get()
            ->toArray();

        // Use case-insensitive like if database on postgres
        // $this->packages = Package::where('name', config('database.default') === 'pgsql' ? 'ilike' : 'like', '%' . $this->query . '%')
        //     ->take(20)
        //     ->get()
        //     ->toArray();
    }

    public function render()
    {
        return view('livewire.search');
    }
}
