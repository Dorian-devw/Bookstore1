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
        Schema::table('pedidos', function (Blueprint $table) {
            // Hacer user_id nullable para usuarios no registrados
            $table->foreignId('user_id')->nullable()->change();
            
            // Agregar campos para usuarios no registrados
            $table->string('cliente_nombre')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_telefono')->nullable();
            $table->text('direccion_entrega')->nullable();
            $table->string('session_id')->nullable();
            
            // Agregar campos para cupones (ya existen, solo agregar descuento si no existe)
            if (!Schema::hasColumn('pedidos', 'descuento')) {
                $table->decimal('descuento', 8, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
            $table->dropColumn([
                'cliente_nombre',
                'cliente_email', 
                'cliente_telefono',
                'direccion_entrega',
                'session_id'
            ]);
            
            // Solo eliminar descuento si existe
            if (Schema::hasColumn('pedidos', 'descuento')) {
                $table->dropColumn('descuento');
            }
        });
    }
};
