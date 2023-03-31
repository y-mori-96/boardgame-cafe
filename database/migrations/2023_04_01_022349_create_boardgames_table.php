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
        Schema::create('boardgames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('barcode')->default('');
            $table->string('image')->default('');
            $table->text('outline')->default('');
            // $table->unsignedBigInteger('play_people_id');
            // $table->unsignedBigInteger('play_time_id');
            $table->timestamps();
            
            /**
             * 外部キー
             */
            // $table->foreign('play_people_id')->references('id')->on('play_people');
            // $table->foreign('play_time_id')->references('id')->on('play_times');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boardgames');
    }
};
