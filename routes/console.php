<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\UpdateStockPrices;

Schedule::command(UpdateStockPrices::class)->everyFifteenSeconds();