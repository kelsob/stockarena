<?php

namespace App\Livewire;
use App\Models\Stock;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;



class Stockspage extends Component
{

    public $stocks;
    public function mount(Stock $stocks)
    {
        $this->stocks = $stocks;
    }
    public function render()
    {
        return view('livewire.stockspage', [
            'stocks'=> $this->stocks
        ]);
    }
    public function setTimeScale()
    {
        Log::info("setting time scale");

    }
}
