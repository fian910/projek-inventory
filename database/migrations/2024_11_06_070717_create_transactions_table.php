<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('inventory_id'); // Relasi dengan inventaris
        $table->integer('jumlah');
        $table->decimal('total_harga', 10, 2);
        $table->timestamps();

        // Foreign key untuk inventaris
        $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('transactions');
}

};
