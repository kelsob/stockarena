<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use App\Models\Stock;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;


#[Layout('components.layouts.app')] 
class Stockspage extends Component
{
    
    use WithPagination;
    public function render()
    {
        return view('livewire.stockspage',
        [
            'stocks' => Stock::paginate(12),
        ]);
    }

}
