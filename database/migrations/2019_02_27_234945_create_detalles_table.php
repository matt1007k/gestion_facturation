<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('cantidad', 8, 2);
            $table->string('nombre', 100);
            $table->string('descripcion', 200);
            $table->decimal('precio', 8, 2);
            $table->decimal('descuento', 8, 2)->default(0.0);
            $table->decimal('subtotal', 8, 2);
            $table->unsignedInteger('venta_id');
            $table->foreign('venta_id')->references('id')
                    ->on('ventas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles');
    }
}
