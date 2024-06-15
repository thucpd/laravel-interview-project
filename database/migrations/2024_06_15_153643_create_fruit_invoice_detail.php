<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fruit_invoice_detail', function (Blueprint $table) {
            $table->increments('fruit_invoice_detail_id');
            $table->integer('fruit_invoice_id');
            $table->integer('fruit_item_id');
            $table->integer('quantity');
            $table->decimal('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fruit_invoice_detail');
    }
};
