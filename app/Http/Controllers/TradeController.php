<?php
// app/Http/Controllers/TradeController.php
namespace App\Http\Controllers;

use App\Models\Trade;

class TradeController extends Controller
{
    public function index()
    {
        return response()->json(Trade::all());
    }
}
