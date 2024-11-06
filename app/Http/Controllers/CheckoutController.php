<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Menampilkan semua barang dari inventaris
        $inventories = Inventory::all();
        return view('checkout.index', compact('inventories'));
    }

    public function store(Request $request)
    {
        // Validasi jumlah barang yang dipesan
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cari barang yang dipesan
        $inventory = Inventory::findOrFail($request->inventory_id);

        // Periksa jika stok cukup
        if ($inventory->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok barang tidak cukup.');
        }

        // Simpan transaksi
        $transaction = new Transaction();
        $transaction->inventory_id = $inventory->id;
        $transaction->jumlah = $request->jumlah;
        $transaction->total_harga = $inventory->harga * $request->jumlah;
        $transaction->save();

        // Kurangi stok barang
        $inventory->stok -= $request->jumlah;
        $inventory->save();

        return redirect()->route('checkout.index')->with('success', 'Barang berhasil dipesan');
    }
}
