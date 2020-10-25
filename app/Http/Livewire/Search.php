<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;

class Search extends Component
{
    public $searchTerm;
    public $packages;

    public function render()
    {
        if (!empty($this->searchTerm))
        {
            $this->packages = Package::search($this->searchTerm)->get();
        }
        else
        {
            $this->packages = [];
        }

        return view('livewire.search');
    }
}
