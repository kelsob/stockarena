<?php

namespace App\Livewire;

use Livewire\Component;

#[Layout('components.layouts.app')] 
class Home extends Component
{
    public function render()
    {
        return view('livewire.home');
    }
}
