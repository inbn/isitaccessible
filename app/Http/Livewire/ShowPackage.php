<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowPackage extends Component
{
    public $package;

    public function render()
    {
        return view('livewire.show-package');
    }
}
