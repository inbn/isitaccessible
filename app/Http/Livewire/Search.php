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
            $searchTerm = '%' . $this->searchTerm. '%';

            $this->packages = Package::where('name', 'like', $searchTerm)->get();
        }
        else
        {
            $this->packages = [];
        }

        return view('livewire.search');
    }
}
