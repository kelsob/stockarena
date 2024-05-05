<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\StockTransactionService;
use Illuminate\Http\Request;
use App\Http\Livewire\StocksTable;

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
        return view('stockspage', [
            'stocks' => $stocks
        ]);
    }

    public function show($id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json(['message' => 'Stock not found'], 404);
        }
        return response()->json($stock);
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
