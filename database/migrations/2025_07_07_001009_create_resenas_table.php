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
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('libro_id')->constrained()->onDelete('cascade');
            $table->integer('calificacion'); // 1-5 estrellas
            $table->text('comentario')->nullable();
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->timestamps();
            
            // Un usuario solo puede reseñar un libro una vez
            $table->unique(['user_id', 'libro_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
