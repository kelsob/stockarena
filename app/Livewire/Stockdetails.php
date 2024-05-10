<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Stock;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.app')] 
class StockDetails extends Component
{
    public $stockId;
    public $stock;
    public $priceHistories;
    public $timeScale = '1D';  // Default time scale is one day.

    public $hourData1;
    public $dayData1;
    public $weekData1;
    public $monthData1;
    public $yearData1;
    public $allData;

    public $priceDifference = null;
    public $percentageDifference = null;

    public $chartType = 'line';

    protected $listeners = ['timeScaleChanged' => 'setTimeScale',
                            'chartTypeChanged' => 'setChartType'];


    public function mount(string $stockId)
    {
        // Use the parameter directly instead of $this->stockId
        $this->stock = Stock::find($stockId);
        $this->fetchDataForScale();
    }
                            

    public function fetchDataForScale()
    {
        $this->priceHistories = $this->stock->priceHistories()
            ->whereBetween('created_at', $this->getTimeRange($this->timeScale))
            ->orderBy('created_at', 'asc')
            ->get(['price', 'created_at']);
        if ($this->priceHistories->isNotEmpty()) {
            $this->priceDifference = $this->priceHistories->last()->price - $this->priceHistories->first()->price;
            $this->percentageDifference = ($this->priceDifference / $this->priceHistories->first()->price) * 100;
        } else {
            $this->priceDifference = 0;
            $this->percentageDifference = 0;
        }
    }

    private function getTimeRange($scale)
    {
        $today = now();
        switch ($scale) {
            case '1H': return [$today->copy()->subHour(), $today];
            case '1D': return [$today->copy()->subDay(), $today];
            case '1W': return [$today->copy()->subWeek(), $today];
            case '1M': return [$today->copy()->subMonth(), $today];
            case '1Y': return [$today->copy()->subYear(), $today];
            default: return [$today->copy()->subDay(), $today];
        }
    }
    public function setTimeScale(string $scale)
    {
        $this->timeScale = $scale;
        $this->fetchDataForScale();
    }

    public function setChartType(string $chartType)
    {
        $this->chartType = $chartType;
    }

    public function render()
    {
        // Prepare labels and data arrays from priceHistories
        $labels = $this->priceHistories->map(function ($entry) {
            return $entry->created_at->format('Y-m-d'); // Format date as you prefer
        })->toArray();
    
        $data = $this->priceHistories->map(function ($entry) {
            return $entry->price;
        })->toArray();
    
        // Convert the labels and data to JSON strings for JavaScript usage
        $labelsJson = json_encode($labels);
        $dataJson = json_encode($data);
    
        // Pass these JSON strings to the view
        return view('livewire.stockdetails', [
            'stock' => $this->stock,
            'priceDifference' => $this->priceDifference,
            'percentageDifference' => $this->percentageDifference,
            'labelsJson' => $labelsJson,
            'dataJson' => $dataJson,
            'chartType'=> $this->chartType,
        ]);
    }
}