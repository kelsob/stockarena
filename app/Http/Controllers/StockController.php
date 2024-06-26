<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\StockTransactionService;
use Illuminate\Http\Request;
use App\Livewire\Stockspage;

class StockController extends Controller
{
    protected $transactionService;

    public function __construct(StockTransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        // Fetch all stocks from the database
        $stocks = Stock::all();
    
        // Pass the stocks data to the view
        return view('livewire.stockspage', [
            'stocks' => $stocks
        ])->extends(Stockspage::class);;
    }

    public function show($stockId)
    {
        $stock = Stock::with('priceHistories')->find($stockId);
        if (!$stock) {
            abort(404, 'Stock not found');
        }

        $dates = $stock->priceHistories->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d'); // Adjust date format as necessary
        });
        $prices = $stock->priceHistories->pluck('price');

        return view('stocks.show', compact('stock', 'dates', 'prices')); // Ensure the view name matches your setup
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric'
        ]);

        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json(['message' => 'Stock not found'], 404);
        }

        $stock->price = $request->price;
        $stock->save();

        return response()->json(['message' => 'Stock updated successfully', 'stock' => $stock]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'ticker' => 'required|string|unique:stocks,ticker',
            'price' => 'required|numeric',
            'description' => 'nullable|string'
        ]);

        $stock = new Stock($request->all());
        $stock->save();

        return response()->json(['message' => 'Stock created successfully', 'stock' => $stock], 201);
    }

    public function buy(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'stock_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric'
        ]);

        try {
            $transaction = $this->transactionService->buyStock(
                $request->user_id,
                $request->stock_id,
                $request->quantity,
                $request->price
            );
            return response()->json(['message' => 'Transaction completed successfully', 'transaction' => $transaction]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function sell(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'stock_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric'
        ]);

        try {
            $transaction = $this->transactionService->sellStock(
                $request->user_id,
                $request->stock_id,
                $request->quantity,
                $request->price
            );
            return response()->json(['message' => 'Transaction completed successfully', 'transaction' => $transaction]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

}
