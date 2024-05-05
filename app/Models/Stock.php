<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'ticker', 'price', 'motto', 'description'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Retrieve all stocks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllStocks()
    {
        return self::all();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_stocks')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    
    /**
     * Get the transactions associated with the stock.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function priceHistories()
    {
        return $this->hasMany(StockPriceHistory::class);
    }
}
