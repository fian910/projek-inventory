<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'inventories'; // Connect to inventories table

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'kategori',
        'stok',
        'harga'
    ];
}