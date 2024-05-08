<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use App\Models\Stock;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')] 
class Stockspage extends Component
{
    
    public $stocks;
    public function mount()
    {
        $this->stocks = Stock::all();
    }
    public function render()
    {
        return view('livewire.stockspage',
        [
            'stocks' => $this->stocks
        ]);
    }

}
