<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Stock;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\On;

class StockListing extends Component
{
    public $stock;
    public $priceHistories;
    #[Reactive]
    public $timeScale = '1D';  // Default time scale is one day.
    #[Reactive]
    public $chartType = 'line';


    public $hourData1;
    public $dayData1;
    public $weekData1;
    public $monthData1;
    public $yearData1;
    public $allData;

    public $priceDifference = null;
    public $percentageDifference = null;


    public function mount($stock, $timeScale, $chartType)
    {
        $this->stock = $stock;
        $this->timeScale = $timeScale;
        $this->chartType = $chartType;
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

            if ($this->priceHistories->first()->price == 0)
            {
                $this->percentageDifference = 0;
            }
            else
            {
                $this->percentageDifference = ($this->priceDifference / $this->priceHistories->first()->price) * 100;
            }
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
        Log::info("stock listing re-rendering.");
        Log::info($this->chartType);
        Log::info($this->timeScale);
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
        return view('livewire.stocklisting', [
            'labelsJson' => $labelsJson,
            'dataJson' => $dataJson,
        ]);
    }
}