<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;

class StockListing extends Component
{
    public $stockId;
    public $stock;
    public $priceHistories;

    public function mount($stockId)
    {
        $this->stock = Stock::find($stockId);
        $this->priceHistories = $this->stock->priceHistories()->orderBy('created_at', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.stocklisting');
    }
}