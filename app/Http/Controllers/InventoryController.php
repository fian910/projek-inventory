<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::paginate(10);
        return view('admin.inventories.index', compact('inventories'));
    }

    public function create()
    {
        return view('admin.inventories.create');
    }

    public function store(Request $request)
{
    // Validations and saving logic
    $inventory = new Inventory();
    $inventory->nama_barang = $request->nama_barang;
    $inventory->kode_barang = $request->kode_barang;
    $inventory->kategori = $request->kategori;
    $inventory->stok = $request->stok;
    $inventory->harga = $request->harga;
    $inventory->save();

    // Flash message
    session()->flash('success', 'Barang berhasil ditambahkan!');

    return redirect()->route('admin.inventories.index');
}

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.inventories.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        // Validations and updating logic
        $inventory = Inventory::find($id);
        $inventory->nama_barang = $request->nama_barang;
        $inventory->kode_barang = $request->kode_barang;
        $inventory->kategori = $request->kategori;
        $inventory->stok = $request->stok;
        $inventory->harga = $request->harga;
        $inventory->save();
    
        // Flash message
        session()->flash('success', 'Barang berhasil diperbarui!');
    
        return redirect()->route('admin.inventories.index');
    }
    public function destroy($id)
    {
        Inventory::destroy($id);
        return redirect()->route('admin.inventories.index')->with('success', 'Barang berhasil dihapus');
    }
}
