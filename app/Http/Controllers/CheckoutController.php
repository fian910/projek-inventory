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

    // Menyimpan transaksi dan mengurangi stok
public function store(Request $request)
{
    // Validasi
    $request->validate([
        'inventory_id' => 'required|exists:inventories,id',
        'jumlah' => 'required|integer|min:1',
    ]);

    $inventory = Inventory::findOrFail($request->inventory_id);

    // Periksa stok barang
    if ($inventory->stok < $request->jumlah) {
        // Jika stok tidak cukup, kirim pesan error
        return redirect()->route('checkout.index')->with('error', 'Stok barang tidak cukup.');
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

    // Kirim pesan sukses
    return redirect()->route('checkout.index')->with('success', 'Barang berhasil dipesan');
}
}
