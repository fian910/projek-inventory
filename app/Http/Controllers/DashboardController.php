<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all items ordered by stock
        $items = Item::orderBy('stok', 'desc')->get();
        
        // Count total items
        $totalItems = Item::count();
        
        // Count available items (stock > 0)
        $availableItems = Item::where('stok', '>', 0)->count();
        
        // Count out of stock items (stock = 0)
        $outOfStockItems = Item::where('stok', 0)->count();

        // Calculate low stock items (stock <= 10)
        $lowStockItems = Item::where('stok', '<=', 10)
            ->where('stok', '>', 0)
            ->count();

        return view('dashboard', compact(
            'items',
            'totalItems',
            'availableItems',
            'outOfStockItems',
            'lowStockItems'
        ));
    }
}