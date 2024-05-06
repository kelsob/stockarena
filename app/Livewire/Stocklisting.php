<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\Stock;


class StockListing extends Component
{
    public $stockId;
    public $stock;
    public $priceHistories;
    public $timeScale = '1Day';  // Default time scale is one day.

    public $hourData1;
    public $dayData1;
    public $weekData1;
    public $monthData1;
    public $yearData1;
    public $allData;

    public function mount()
    {
        $this->stock = Stock::find($this->stockId);
        $this->fetchDataForScale();

    }

    public function fetchDataForScale()
    {
        $this->priceHistories = $this->stock->priceHistories()
            ->whereBetween('created_at', $this->getTimeRange($this->timeScale))
            ->orderBy('created_at', 'asc')
            ->get(['price', 'created_at']);
    }

    private function getTimeRange($scale)
    {
        $today = now();
        switch ($scale) {
            case '1Hour': return [$today->copy()->subHour(), $today];
            case '1Day': return [$today->copy()->subDay(), $today];
            case '1Week': return [$today->copy()->subWeek(), $today];
            case '1Month': return [$today->copy()->subMonth(), $today];
            case '1Year': return [$today->copy()->subYear(), $today];
            default: return [$today->copy()->subDay(), $today];
        }
    }
    #[On('updateCharts')]
    public function setTimeScale($scale)
    {
        Log::info("setting time scale");
        $this->timeScale = $scale;
        $this->fetchDataForScale();
    }

    public function render()
    {
        Log::info("rendering");

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
            'stock' => $this->stock,
            'labelsJson' => $labelsJson,
            'dataJson' => $dataJson
        ]);
    }
}