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
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('hotel_id');
            $table->integer('cantidad');
            $table->enum('tipo_habitacion', ['Estándar', 'Junior', 'Suite']);
            $table->enum('acomodacion', ['Sencilla', 'Doble', 'Triple', 'Cuádruple']);
            $table->timestamps();
            $table->foreign('hotel_id')
                ->references('id')
                ->on('hoteles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};
