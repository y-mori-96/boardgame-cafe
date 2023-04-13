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
        Schema::create('rental_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('boardgame_id');
            $table->boolean('state')->default(true);
            $table->integer('stock_quantity')->default(1);
            $table->timestamps();
            
            $table->foreign('boardgame_id')->references('id')->on('boardgames')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
