<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_id', 'jumlah', 'total_harga'];

    // Relasi dengan Inventory
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
