<?php

namespace App\Livewire;

use Livewire\Component;
#[Layout('components.layouts.app')] 
class Portfolio extends Component
{
    public function render()
    {
        return view('livewire.portfolio');
    }
}
