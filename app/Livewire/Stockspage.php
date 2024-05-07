<?php

namespace App\Livewire;
use App\Models\Stock;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Stockspage extends Component
{

    public $stocks;
    public function mount()
    {
        $this->stocks = Stock::all();
    }
    public function render()
    {
        return view('livewire.stockspage', [
            'stocks'=> $this->stocks
        ])->layout('layouts.app');
    }
    
    public function testFunction()
    {
        Log::info("testing wire");
    }
}
