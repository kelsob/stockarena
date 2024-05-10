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

    public $timeScale = '1D';
    public $chartType = 'line';

    protected $listeners = ['timeScaleChanged' => 'setTimeScale',
                            'chartTypeChanged' => 'setChartType'];

    public function setTimeScale(string $scale)
    {
        $this->timeScale = $scale;

    }

    public function setChartType(string $chartType)
    {
        $this->chartType = $chartType;

    }

    public function render()
    {
        return view('livewire.stockspage',
        [
            'stocks' => Stock::paginate(12),
            'timeScale' => $this->timeScale,
            'chartType' => $this->chartType,
        ]);
    }

}
