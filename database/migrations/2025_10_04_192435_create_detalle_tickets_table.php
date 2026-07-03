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
    Schema::create('detalle_ticket', function (Blueprint $table) {
        $table->id('id_detalle');
        $table->unsignedBigInteger('id_ticket');
        $table->unsignedBigInteger('id_producto');
        $table->integer('Cantidad');
        $table->decimal('Precio_unitario', 10, 2);
        $table->decimal('Importe', 10, 2);
        $table->foreign('id_ticket')->references('id_ticket')->on('ticket')->onDelete('cascade');
        $table->foreign('id_producto')->references('id_producto')->on('producto')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_tickets');
    }
};
